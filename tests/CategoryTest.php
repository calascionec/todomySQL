<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $server = 'mysql:host=localhost; dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Category::deleteAll();
            Task::deleteAll();
        }

        function test_getName()
        {
            $name = "Work stuff";
            $test_Category = new Category($name);

            $result = $test_Category->getName();

            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            //Arrange
            $name = "Kitchen chores";
            $test_category = new Category($name);

            //Act
            $test_category->setName("Home chores");
            $result = $test_category->getName();

            //Assert
            $this->assertEquals("Home chores", $result);
        }

        function test_getId()
        {
            $name = "Work stuff";
            $id = 1;
            $test_Category = new Category($name, $id);

            $result = $test_Category->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            $name = "Work stuff";
            $test_Category = new Category($name);
            $test_Category->save();

            $result = Category::getAll();

            $this->assertEquals($test_Category, $result[0]);
        }

        function test_update()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $new_name = "Home stuff";

            //Act
            $test_category->update($new_name);

            //Assert
            $this->assertEquals("Home stuff", $test_category->getName());
        }

        function test_deleteCategory()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Home stuff";
            $id2 = 2;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            //Act
            $test_category->delete();

            //Assert
            $this->assertEquals([$test_category2], Category::getAll());
        }

        function test_getAll()
        {
            $name = "Work stuff";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();

            $result = Category::getAll();

            $this->assertEquals([$test_Category, $test_Category2], $result);
        }

        function test_deleteAll()
        {
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();

            Category::deleteAll();
            $result = Category::getAll();

            $this->assertEquals([], $result);
        }

        function test_find()
        {
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();

            $result = Category::find($test_Category->getId());

            $this->assertEquals($test_Category, $result);
        }

    }
?>
