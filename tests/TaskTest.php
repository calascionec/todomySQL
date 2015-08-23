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
             Category::deleteAll();
         }

         function test_getDescription()
         {
             //Arrange
             $description = "Do dishes";
             $test_task = new Task($description);

             //Act
             $result = $test_task->getDescription();

             //Assert
             $this->assertEquals($description, $result);
         }

         function test_setDescription()
         {
             //Arrange
             $description = "Do dishes";
             $test_task = new Task($description);

             //Act
             $test_task->setDescription("Drink coffee.");
             $result = $test_task->getDescription();

             //Assert
             $this->assertEquals("Drink coffee.", $result);
         }

         function test_getId()
         {
             //Arrange
             $id = 1;
             $description = "Wash the dog";
             $test_task = new Task($description, $id);

             //Act
             $result = $test_task->getId();

             //Assert
             $this->assertEquals(1, $result);
         }

         function test_save()
         {
             //Arrange

             $description = "Wash the dog";
             $id = 1;
             $due_date = '2015-08-29';
             $test_task = new Task($description, $id, $due_date);

             //Act
             $test_task->save();

             //Assert
             $result = Task::getAll();
             $this->assertEquals($test_task, $result[0]);

         }

         function test_saveSetsId()
         {
             //Arrange
             $description = "Wash the dog";
             $id = 1;
             $test_task = new Task($description, $id);

             //Act
             $test_task->save();

             //Assert
             $this->assertEquals(true, is_numeric($test_task->getId()));
         }

         function test_getAll()
         {
             //Arrange

             $description = "Wash the dog";
             $due_date = "2020-08-01";
             $id = 1;
             $test_Task = new Task ($description, $id, $due_date);
             $test_Task->save();

             $description2 = "Water the lawn";
             $id2 = 2;
             $due_date2 = "2015-08-05";
             $test_Task2 = new Task ($description2, $id2, $due_date2);
             $test_Task2-> save();

             //Act
             $result = Task::getAll();

             //Assert
             $this->assertEquals([$test_Task, $test_Task2], $result);
         }

         function test_deleteAll()
         {
             //Arrange

             $description = "Wash the dog";
             $id = 1;
             $test_Task = new Task($description, $id);
             $test_Task->save();

             $description2 = "Water the lawn";
             $id2 = 2;
             $test_Task2 = new Task($description2, $id);
             $test_Task2->save();

             //Act
             Task::deleteAll();

             //Assert
             $result = Task::getAll();
             $this->assertEquals([], $result);
         }

         function test_find()
         {
             //Arrange

             $description = "Wash the Dog";
             $id = 1;
             $due_date = "2016-09-10";
             $test_Task = new Task ($description, $id, $due_date);
             $test_Task->save();

             $description2 = "Water the Lawn";
             $id2 = 2;
             $test_Task2 = new Task ($description2, $id, $due_date);
             $test_Task2->save();

             //Act
             $result = Task::find($test_Task->getId());

             //Assert
             $this->assertEquals($test_Task, $result);
         }

         function test_update()
         {
             //Arrange
             $description = "Wash the Dog";
             $id = 1;
             $due_date = "2016-09-10";
             $test_Task = new Task ($description, $id, $due_date);
             $test_Task->save();

             $new_description = "Clean the dog";

             //Act
             $test_Task->update($new_description);

             //Assert
             $this->assertEquals("Clean the dog", $test_Task->getDescription());
         }

         function test_deleteTask()
         {
             //Arrange

             $description = "Wash the Dog";
             $id = 1;
             $due_date = "2016-09-10";
             $test_Task = new Task ($description, $id, $due_date);
             $test_Task->save();

             $description2 = "Water the Lawn";
             $id2 = 2;
             $test_Task2 = new Task ($description2, $id, $due_date);
             $test_Task2->save();

             //Act
             $test_Task->delete();

             //Assert
             $this->assertEquals([$test_Task2], Task::getAll());
         }

         function test_getDueDate()
         {
             //Arrange

             $description = "Wash the dog";
             $id = 2;
             $due_date = '2015-05-04';
             $test_Task = new Task($description, $id, $due_date);

             //Act
             $result = $test_Task->getDueDate();

             //Assert
             $this->assertEquals('2015-05-04', $result);

         }

         function test_addCategory()
         {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "File reports";
            $id2 = 2;
            $test_task = new Task($description, $id2);
            $test_task->save();

            //Act
            $test_task->addCategory($test_category);

            //Assert
            $this->assertEquals($test_task->getCategories(), [$test_category]);
         }

         function test_getCategories()
         {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Volunteer stuff";
            $id2 = 2;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            $description = "File reports";
            $id3 = 3;
            $test_task = new Task($description, $id3);
            $test_task->save();

            //Act
            $test_task->addCategory($test_category);
            $test_task->addCategory($test_category2);

            //Assert
            $this->assertEquals($test_task->getCategories(), [$test_category, $test_category2]);
         }

         function test_delete()
         {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "File reports";
            $id2 = 2;
            $test_task = new Task($description, $id2);
            $test_task->save();

            //Act
            $test_task->addCategory($test_category);
            $test_task->delete();

            //Assert
            $this->assertEquals([], $test_category->getTasks());
         }
     }

?>
