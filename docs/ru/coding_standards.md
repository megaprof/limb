# Стандарты кодирования
## Общее редактирование кода

* используйте **только пробелы** для идентации кода вместо табуляторов, во всех современных редакторах есть функция замены табуляторов пробелами (скажем, в JEdit эта опция называется soft tabs)
* один табулятор равен 2(двум) пробелам (к примеру, в JEdit, Tab width = 2, Indent Width = 2)
* по возможности используйте просто «\n» для окончания строк (Unix newline — в настройках редактора)

## Языковые конструкции
### Обрамление <?php..?>

* в Limb3 является стандартной практикой **не заканчивать** код PHP модулей строкой **?>**. Связано это с тем, что:
  * эта строка на самом деле не нужна в модулях
  * любые невидимые символы после ?> попадают в stdout, что может привести к крайне сложным для отлова ошибкам

### Операторы

* все операторы(кроме инкрементных) разделяются одиночным пробелом:
  **$a = 1**, но не $a=1; однако $i++
* после управляющей конструкции(if, for, etc) не следует использовать пробелы перед скобкой и внутри скобок:
  **if($a == 1)**, но не if ( $a == 1 )
* если после управляющих конструкций следует однострочная операция, {} можно не использовать

### Идентация, новые строка и проч.

* изначально код имеет нулевое смещение относительно левого края
* {…} используются с новой строки без исключения
* код в блоках внутри {…} имеет идентацию на один уровень вправо относительно {}
* старайтесь группировать несколько схожих операций в безинтервальные блоки
* логически сгруппированные блоки отделяются символом новой строки

### Функции, переменные, классы, методы и проч.
#### Названия

* Limb3 специфичные константы начинаются с префикса **LIMB_**
* Limb3 классы и функции имеют обязательный префикс **lmb**
* для названий классов следует использовать формат MyClassName:
  **class MyClassName{}**, но не my_class_name
* для названий методов следует использовать формат methodName:
  **function methodName(){}**
* для названий глобальных функций следует использовать формат function_name: 
  **function function_name(){}**
* переменные/аттрибуты могут иметь название **$varName** либо **$var_name**, и хотя это не принципиально, мы все же склоняемся к использованию $var_name

#### Уровни доступа(public/protected/private)

* ключевое слово **public** обычно опускается для методов, т.к оно является излишним(все методы public по умолчанию)
* уровень доступа **private** не используется вообще, т.к может усложнять тестирование и расширение функционала, рекомендуется использовать уровень доступа protected
* закрытые(protected) методы обычно отмечаются начальным символом «_»:
  **protected function _doThisPrivately(){}**
* всем аттрибутам рекомендуется ставить уровень доступа protected
* уровень доступа final рекомендуется использовать только в крайних случаях, когда в этом есть уверенность на **10000%** (final может представлять трудности во время расширения функционала и тестирования).

#### TypeHints
На данный момент в кодовой базе Limb3 не используются typehints, однако в целях повышения читаемости кода и улучшения документации вполне вероятно их использование в будущем.

### Включения PHP исходных файлов

* Для подключения исходного кода в Limb3 обычно используется глобальная функция **lmb_require** из пакета CORE. Она практически аналогична функции require/include_once, однако позволяет отложенно загружать код, используя механизм autoload. Подробее о средствах отложенной загрузки можно прочитать [здесь](../../core/docs/ru/core/lazy_include.md).

### Комментарии

* комментарии по логике работы кода мы почти пока не делаем, ибо хороший код обычно говорит сам за себя и, к тому же, есть тесты
* комментарии по логике работы кода обычно уместны в тех местах кода, который пока еще не подвергался рефакторингу и поэтому его «читабельность» затруднена
* комментарии допустимы **исключительно на английском языке**
* однако, в целях улучшения API документации постепенно вводятся комментарии в стиле phpDocumentor для классов и функций
* также комментарии бывают исключительно полезны в тестах, где с их помощью можно сделать акцент на тонкости тестирования

### Общий лицензионный заголовок

* лицензионная «шапка» для кода(обычно в редакторе можно настроить систему шаблонов и вызывать шаблоны один кликом):

        /*
         * Limb PHP Framework
         *
         * @link http://limb-project.com
         * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
         * @license    LGPL http://www.gnu.org/copyleft/lesser.html
         */

### PHPDocumentor заголовок для пакета

* код в библиотеке Limb3 находится в том или ином пакете, поэтому для того, чтобы правильно генерировалась API документация, необходимо непосредственно перед кодом(однако после общего лицензионного заголовка) поместить следующий заголовок:

        /**
         * @package package_name
         * @version $Id$
         */

Примеры возможных шаблонов для vim snippetsemu плагина:

    let st = g:snip_start_tag
    let et = g:snip_end_tag
    let cd = g:snip_elem_delim

    exec "Snippet lic /*<CR> * Limb PHP Framework<CR><CR>@link http://limb-project.com<CR>@copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)<CR>@license    LGPL http://www.gnu.org/copyleft/lesser.html<CR>/<CR>".st.et
    exec "Snippet pak /**<CR> * @package package_name<CR>@version $Id$<CR>/<CR>".st.et
    exec "Snippet lpak /*<CR> * Limb PHP Framework<CR><CR>@link http://limb-project.com<CR>@copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)<CR>@license    LGPL http://www.gnu.org/copyleft/lesser.html<CR>/<CR><CR>/**<CR>@package package_name<CR>@version $Id$<CR>/<CR>".st.et

## Расположение кода в файловой системе

* **один класс = один файл**, тоже самое относится к интерфейсам
* все файлы с классами имеют case sensitive название: **ClassName.class.php**, где ClassName название класса, а расширение **.class.php** указывает на то, что это класс
* тоже самое относится к интерфейсам, с небольшими изменениями: **Doable.interface.php**, где Doable название интерфейса, а расширение **.interface.php** указывает на то, что это интерфейс
* подключаемый модуль имеет расширение **.inc.php**
* исполняемый скрипт обычно имеет расширение **.php** (здесь есть некоторые исключения из правила, скажем, setup.php, который не является самостоятельным исполняющимся скриптом)
* тесты для одного класса обычно имеют такое же название, что и сам класс + окончание **Test**, т.е **MyClassTest**
* тесты обычно имеют паралельную структуру с основным кодом, т.е /src/util/lmbComplexArray.class.php ⇒ /cases/util/ComplexArrayTest.class.php

## Пример кода

    <?php
    /*
     * Limb PHP Framework
     *
     * @link http://limb-project.com
     * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
     * @license    LGPL http://www.gnu.org/copyleft/lesser.html
     */
 
    /**
     * @package foo
     * @version $Id$
     */
    lmb_require('limb/some/package/Foo.class.php'); 
 
    /**
     * Some FooClass description
     *
     * @version $Id$
     * @package foo
     */
    class FooClass
    {
      /**
       * @var string foo name 
       */
      protected $foo_name;
      /**
       * @var object request 
       */
      protected $request;
 
      /**
       *  Constructor.
       *  Creates an instance of FooClass object in different ways depending on passed argument
       *  @param object request
       */
      function __construct($request)
      {
        $this->request = $request;
        $this->foo_name = 'Foo';
      }
 
      /**
       *  Echoes some stuff
       */
      function doIt()
      {
        if($this->foo_name == 'Bar')
        {
          $res = globalDoIt();
          echo $res;
        }
 
        //для простых управляющих конструкций {} можно опускать
        if($this->foo_name == 'Test')
          return;
 
        //логически сгруппированный блок кода
        $db = getDbConnection();
        $it = $db->exec('select * from a');
 
        foreach($it as $record)
          echo $record->get('id');
 
        $i++;
      }
 
      protected function _createBar()
      {
        return new Bar(); 
      }
    }
 
    /**
     *  Some global function
     *  @return integer some number
     */
    function globalDoIt()
    {
      $some_var = 1;
      return 1;
    }
