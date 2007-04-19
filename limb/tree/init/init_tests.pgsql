
DROP TABLE test_materialized_path_tree CASCADE;
CREATE TABLE test_materialized_path_tree (
  "id" SERIAL,
  "root_id" int NOT NULL default '0',
  "parent_id" int NOT NULL default '0',
  "level" int NOT NULL default '0',
  "identifier" varchar(128) NOT NULL default '',
  "path" varchar(255) NOT NULL default '',
  "children" int NOT NULL default '0',
  "priority" int default NULL,
  PRIMARY KEY  ("id")
) ;

DROP TABLE test_nested_sets_tree CASCADE;
CREATE TABLE test_nested_sets_tree (
  "id"      INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  "parent_id" int NOT NULL default '0',
  "c_left"    INT(11) UNSIGNED NOT NULL,
  "c_right"   INT(11) UNSIGNED NOT NULL,
  "c_level"   INT(11) UNSIGNED NOT NULL,
  "identifier" varchar(128) NOT NULL,
  PRIMARY KEY("id"),
  KEY("c_left", "c_right", "c_level")
) ;