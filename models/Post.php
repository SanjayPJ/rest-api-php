<?php 
    class Post{
        //db parameters
        private $conn;
        private $table = 'posts';

        //post parameters
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        //constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        //get posts
        public function read(){
            //create query
            $query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
                FROM ' . $this->table . ' p 
                LEFT JOIN 
                categories c ON p.category_id = c.id
                ORDER BY
                p.created_at DESC';
            // echo $query;

            //prepare and excecute statement
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        //get single post
        public function read_single(){
            //create query
            $query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
                FROM ' . $this->table . ' p 
                LEFT JOIN 
                categories c ON p.category_id = c.id
                WHERE p.id = ?
                LIMIT 0, 1';
            //prepare and excecute statement
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->title = $result['title'];            
            $this->body = $result['body'];            
            $this->author = $result['author'];            
            $this->category_id = $result['category_id'];            
            $this->category_name = $result['category_name'];            
        }

        //create post
        public function create(){
            //create query
            $query = 'INSERT INTO ' . $this->table . ' SET 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id';
            
            //prepare query
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // binding data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);

            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
?>