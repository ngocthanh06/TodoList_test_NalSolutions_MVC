<?php

class TodoLists extends Controller 
{
    public function __construct() 
    {
        $this->todoModel = $this->model('Todo');
    }

    public function create() 
    {
        $data = [
            'nameWorkError' => '',
            'startDateError' => '',
            'endDateError' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $now = strtotime(date("Y-m-d H:i:s"));

            $data = [
                'name_work' => trim($_POST['name_work']),
                'start_date' => trim($_POST['start_date']),
                'end_date' => trim($_POST['end_date']),
                'status' => (int)$_POST['status']
            ];

            $errors = [];            

            if (empty($data['name_work'])) {
                $errors['nameWorkError'] = 'The name work cannot be empty';
            }
            
            if (empty($data['start_date'])) {
                $errors['startDateError'] = 'The start date cannot be empty';
            } else if (strtotime($data['start_date']) < $now) {
                $errors['startDateError'] = 'Time cannot be less than the current time';
            }

            if (empty($data['end_date'])) {
                $errors['endDateError'] = 'The end date cannot be empty';
            } else if (strtotime($data['end_date']) <= strtotime($data['start_date'])) {
                $errors['endDateError'] = 'Thime cannot be less than the start time';
            }

            if (!empty($errors)) {
                $this->view('todoLists/create', array_merge($data, $errors));
            } else {
                if ($this->todoModel->addTodo($data)) {
                    $_SESSION['notice'] =  'Add Todo Success';

                    header("Location: " . URLROOT . "/todoLists/lists");
                } else {
                    die ("Something went wrong, please try again!");
                }
            }
        } 

        $this->view('todoLists/create', $data);
    }

    public function lists()
    {
        $data = $this->todoModel->showTodo();
        
        $this->view('todoLists/index', $data);
    }

    public function update($id)
    {
        $data = $this->todoModel->update($id);

        $data['nameWorkError'] = '';
        $data['startDateError'] = '';
        $data['endDateError'] = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $now = strtotime(date("Y-m-d H:i:s"));

            $data['name_work'] = trim($_POST['name_work']);
            $data['start_date'] = trim($_POST['start_date']);
            $data['end_date'] = trim($_POST['end_date']);
            $data['status'] = (int)$_POST['status'];

            $errors = [];            

            if (empty($data['name_work'])) {
                $errors['nameWorkError'] = 'The name work cannot be empty';
            }
            
            if (empty($data['start_date'])) {
                $errors['startDateError'] = 'The start date cannot be empty';
            } else if (strtotime($data['start_date']) < $now) {
                $errors['startDateError'] = 'Time cannot be less than the current time';
            }

            if (empty($data['end_date'])) {
                $errors['endDateError'] = 'The end date cannot be empty';
            } else if (strtotime($data['end_date']) <= strtotime($data['start_date'])) {
                $errors['endDateError'] = 'Thime cannot be less than the start time';
            }

            if (!empty($errors)) {
                $this->view('todoLists/update', array_merge($data, $errors));
            } else {
                if ($this->todoModel->updateTodo($data, $id)) {
                    $_SESSION['notice'] =  'Update Todo Success';

                    header("Location: " . URLROOT . "/todoLists/lists");
                } else {
                    die ("Something went wrong, please try again!");
                }
            }
        } 

        $this->view('todoLists/update', $data);
    }

    public function delete($id)
    {
        if ($this->todoModel->delete('todo', $id)) {
            $_SESSION['notice'] =  'Delete Todo Success';

            header("Location: " . URLROOT . "/todoLists/lists");
        } else {
            die ("Something went wrong, please try again!");
        }
    }
}
