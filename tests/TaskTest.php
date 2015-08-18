<?php
     /**
     * @backupGlobals disabled
     * @backupStaticAttributes disabled
     */

     require_once "src/Task.php";
     require_once "src/Category.php";


     $server = 'mysql:host=localhost;dbname=to_do_test';
     $username = 'root';
     $password = 'root';
     $DB = new PDO($server, $username, $password);

     class TaskTest extends PHPUnit_Framework_TestCase
     {

         protected function tearDown()
         {
             Task::deleteAll();
         }

         function test_save()
         {
             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->save();

             $description = "Wash the dog";
             $category_id = $test_category->getId();
             $due_date = '2015-08-29';
             $test_task = new Task($description, $id, $category_id, $due_date);

             //Act
             $test_task->save();

             //Assert
             $result = Task::getAll();
             $this->assertEquals($test_task, $result[0]);

         }

         function test_getAll()
         {
             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->save();

             $description = "Wash the dog";
             $category_id = $test_category->getId();
             $due_date = "2020-08-01";
             $test_Task = new Task ($description, $id, $category_id, $due_date);
             $test_Task->save();

             $description2 = "Water the lawn";
             $due_date2 = "2015-08-05";
             $test_Task2 = new Task ($description2, $id, $category_id, $due_date2);
             $test_Task2-> save();

             //Act
             $result = Task::getAll();

             //Assert
             $this->assertEquals([$test_Task2, $test_Task], $result);
         }

         function test_deleteAll()
         {
             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->save();

             $description = "Wash the dog";
             $category_id = $test_category->getId();
             $test_Task = new Task($description, $id, $category_id);
             $test_Task->save();

             $description2 = "Water the lawn";
             $test_Task2 = new Task($description2, $id, $category_id);
             $test_Task2->save();

             //Act
             Task::deleteAll();

             //Assert
             $result = Task::getAll();
             $this->assertEquals([], $result);
         }

         function test_getId()
         {

             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->save();


             $description = "Wash the dog";
             $category_id = $test_category->getId();
             $test_Task = new Task($description, $id, $category_id);
             $test_Task->save();


             //Act
             $result = $test_Task->getId();

             //Assert
             $this->assertEquals(true, is_numeric($result));
         }

         function test_getCategoryId()
         {

           //Arrange
           $name = "Home stuff";
           $id = null;
           $test_category = new Category($name, $id);
           $test_category->save();

           $description = "Wash the dog";
           $category_id = $test_category->getId();
           $test_Task = new Task($description, $id, $category_id);
           $test_Task->save();

           //Act
           $result = $test_Task->getCategoryId();

           //Assert
           $this->assertEquals(true, is_numeric($result));

         }

         function test_find()
         {
             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->save();

             $description = "Wash the Dog";
             $category_id = $test_category->getId();
             $due_date = "2016-09-10";
             $test_Task = new Task ($description, $id, $category_id, $due_date);
             $test_Task->save();

             $description2 = "Water the Lawn";
             $test_Task2 = new Task ($description2, $id, $category_id, $due_date);
             $test_Task2->save();

             //Act
             $result = Task::find($test_Task->getId());

             //Assert
             $this->assertEquals($test_Task, $result);
         }

         function test_getDueDate()
         {
             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->save();

             $description = "Wash the dog";
             $category_id = $test_category->getId();
             $due_date = '2015-05-04';
             $test_Task = new Task($description, $id, $category_id, $due_date);

             //Act
             $result = $test_Task->getDueDate();

             //Assert
             $this->assertEquals('2015-05-04', $result);

         }

         function test_orderTasks()
         {
             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->save();

             $description = "Wash the dog";
             $category_id = $test_category->getId();
             $due_date = '2015-08-20';
             $test_Task = new Task($description, $id, $category_id, $due_date);
             $test_Task->save();

             $description2 = "Wash the cat";
             $category_id2 = $test_category->getId();
             $due_date2 = '2015-08-21';
             $test_Task2 = new Task($description2, $id, $category_id2, $due_date2);
             $test_Task2->save();

             $description3 = "Wash the car";
             $category_id3 = $test_category->getId();
             $due_date3 = '2015-08-14';
             $test_Task3 = new Task($description3, $id, $category_id3, $due_date3);
             $test_Task3->save();

             //Act
             $result = Task::getAll();

             //Assert
             $this->assertEquals([$test_Task3, $test_Task, $test_Task2], $result);
         }
     }

?>
