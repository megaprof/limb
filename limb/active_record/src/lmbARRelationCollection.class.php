<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */
lmb_require('limb/core/src/lmbCollectionInterface.interface.php');
lmb_require('limb/core/src/lmbCollection.class.php');
lmb_require('limb/dbal/src/criteria/lmbSQLCriteria.class.php');

/**
 * abstract class lmbARRelationCollection.
 *
 * @package active_record
 * @version $Id: lmbARRelationCollection.class.php 6691 2008-01-15 14:55:59Z serega $
 */
abstract class lmbARRelationCollection implements lmbCollectionInterface
{
  protected $relation;
  protected $relation_info;
  protected $owner;
  protected $dataset;
  protected $conn;
  protected $is_owner_new;
  protected $decorators = array();
  protected $fetch_with_relations = array();
  protected $default_params = array();

  function __construct($relation, $owner, $criteria = null, $conn = null)
  {
    $this->relation = $relation;
    $this->owner = $owner;
    $this->relation_info = $owner->getRelationInfo($relation);
    $this->default_params['criteria'] = lmbSQLCriteria :: objectify($criteria);
    $this->default_params['sort'] = array();

    if(is_object($conn))
      $this->conn = $conn;
    else
      $this->conn = lmbToolkit :: instance()->getDefaultDbConnection();

    $this->reset();
  }

  function setCriteria($criteria)
  {
    $this->criteria = lmbSQLCriteria :: objectify($criteria);
  }

  function reset()
  {
    $this->is_owner_new = $this->owner->isNew();
    $this->dataset = null;
  }

  protected function _ensureDataset()
  {
    if(is_object($this->dataset))
      return;

    if($this->is_owner_new)
      $this->dataset = new lmbCollection();
    else
      $this->dataset = $this->find();
  }

  function find($magic_params = array())
  {
    if($this->is_owner_new)
      throw new lmbException('Not implemented for in memory collection');

    if(is_string($magic_params) || is_object($magic_params))
      $magic_params = array('criteria' => lmbSQLCriteria :: objectify($magic_params));
    
    $magic_params['criteria'] = isset($magic_params['criteria']) ? $magic_params['criteria']->addAnd($this->default_params['criteria']) : $this->default_params['criteria'];
    $magic_params['sort'] = isset($magic_params['sort']) ? $magic_params['sort'] : $this->default_params['sort'];
    
    $query = $this->_createARQuery($magic_params);
    
    foreach($this->fetch_with_relations as $relation)
      $query->with($relation);
    
    $rs = $query->fetch();
    
    return $this->_applyDecorators($rs);
  }

  function findFirst($magic_params = array())
  {
    $rs = $this->find($magic_params);
    $rs->rewind();
    if($rs->valid())
      return $rs->current();
  }
  
  function with($relation_name)
  {
    $this->fetch_with_relations[] = $relation_name;
    return $this;
  }

  static function createFullARQueryForRelation($class, $relation_info, $conn, $magic_params = array())
  {
    $object = new $relation_info['class'];

    $criteria = isset($magic_params['criteria']) ? $magic_params['criteria'] : new lmbSQLCriteria();
    
    $has_class_criteria = false;
    if(isset($magic_params['class']))
    {
      $filter_object = new $magic_params['class'];
      $criteria = $filter_object->addClassCriteria($criteria);
      $has_class_criteria = true;
    }

    if(!$has_class_criteria)
      $object->addClassCriteria($criteria);

    $query = call_user_func_array(array($class, 'createCoreARQueryForRelation'), array($relation_info, $conn));
    
    $query->addCriteria($criteria);

    $sort_params = array();
    if(isset($magic_params['sort']))
      $sort_params = $magic_params['sort'];
    
    self :: applySortParams($query, $relation_info, $sort_params);
    
    return $query;
  }
  
  abstract static function createCoreARQueryForRelation($relation_info, $conn);
  
  abstract protected function _createARQuery($magic_params = array());

  static function applySortParams($query, $relation_info, $sort_params = array())
  {
    if(count($sort_params))
    {
      $query->order($sort_params);
      return;
    }
    
    if(isset($relation_info['sort_params']) &&
       is_array($relation_info['sort_params']) &&
       count($relation_info['sort_params']))
    {
      $query->order($relation_info['sort_params']);
      return;
    }

    $class = $relation_info['class'];
    $object = new $class();
    if(count($default_sort_params = $object->getDefaultSortParams()))
    {
      $query->order($default_sort_params);
      return;
    }
  }

  function rewind()
  {
    $this->_ensureDataset();

    return $this->dataset->rewind();
  }

  function next()
  {
    return $this->dataset->next();
  }

  function current()
  {
    return $this->dataset->current();
  }

  function valid()
  {
    return $this->dataset->valid();
  }

  function key()
  {
    return $this->dataset->key();
  }

  function add($object)
  {
    if(!$this->is_owner_new)
    {
      $this->_saveObject($object);
      $this->dataset = null;
    }
    else
    {
      $this->_ensureDataset();
      $this->dataset->add($object);
    }
  }

  function save($error_list = null)
  {
    $this->_ensureDataset();

    if(is_a($this->dataset, 'lmbCollection'))
    {
      foreach($this->dataset as $object)
        $this->_saveObject($object, $error_list);
    }

    $this->reset();
  }

  function getArray()
  {
    $result = array();
    foreach($this as $record)
      $result[] = $record;
    return $result;
  }

  function export()
  {
    return $this->getArray();
  }

  function getIds()
  {
    $result = array();
    foreach($this->getArray() as $record)
      $result[] = $record->getId();
    return $result;
  }

  //ArrayAccess interface
  function offsetExists($offset)
  {
    return !is_null($this->offsetGet($offset));
  }

  function offsetGet($offset)
  {
    if(is_numeric($offset))
      return $this->at((int)$offset);
  }

  function offsetSet($offset, $value)
  {
    if(!isset($offset))
      $this->add($value);
  }

  function offsetUnset($offset){}
  //end

  //Countable interface
  function count()
  {
    $this->_ensureDataset();
    return $this->dataset->count();
  }
  //end

  function at($pos)
  {
    $this->_ensureDataset();
    return $this->dataset->at($pos);
  }

  function paginate($offset, $limit)
  {
    $this->_ensureDataset();
    $this->dataset->paginate($offset, $limit);
    return $this;
  }

  function getLimit()
  {
    return $this->dataset->getLimit();
  }

  function getOffset()
  {
    return $this->dataset->getOffset();
  }

  function sort($params)
  {
    if($this->is_owner_new)
    {
      $this->_ensureDataset();
      $this->dataset->sort($params);
    }
    else
    {
      // we want to give users ability to change sort params at any time so we just save the last sort params 
      //  and apply them at the last moment in find() method or even deeper
      $this->default_params['sort'] = $params;
    }
    return $this;
  }

  function countPaginated()
  {
    return $this->dataset->countPaginated();
  }

  function removeAll()
  {
    if($this->is_owner_new)
      return $this->reset();

    $this->_removeRelatedRecords();
  }

  abstract function set($objects);

  abstract protected function _removeRelatedRecords();

  abstract protected function _saveObject($object, $error_list = null);

  function addDecorator($decorator, $params = array())
  {
    $this->decorators[] = array($decorator, $params);
  }

  protected function _applyDecorators($dataset)
  {
    $toolkit = lmbToolkit :: instance();

    foreach($this->decorators as $decorator_data)
    {
      $class_path = new lmbClassPath($decorator_data[0]);
      $dataset = $class_path->createObject(array($dataset));
      $this->_addParamsToDataset($dataset, $decorator_data[1]);
    }
    return $dataset;
  }

  protected function _addParamsToDataset($dataset, $params)
  {
    foreach($params as $param => $value)
    {
      $method = lmb_camel_case('set_'.$param, false);
      $dataset->$method($value);
    }
  }
}


