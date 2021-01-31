<?php
    class Todo 
    {
        private $db;

        public function __construct() 
        {
            $this->db = new Database;
        }

        public function showTodo()
        {
            $this->db->query("SELECT * FROM todo ORDER BY id DESC");

            return $this->db->resultSet();
        }

        public function addTodo($data)
        {
            $data = [
                'name_work' => $data['name_work'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => $data['status']
            ];

            $this->db->insert('todo', $data);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        //post
        public function updateTodo($data, $id)
        {
            $data = [
                'name_work' => $data['name_work'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => $data['status']
            ];
            
            $this->db->update('todo', $data, ['id' => $id]);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
        
        //get
        public function update($id)
        {
            $this->db->query("SELECT * FROM todo WHERE id = '$id'");

            return $this->db->resultSet();
        }

        public function delete ($table ,  $id, $col = null )
        {
            $this->db->delete($table, $id, $col);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
