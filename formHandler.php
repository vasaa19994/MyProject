<?php
 namespace Maincast\App\classes;
 
 use Maincast\App\classes\abstractMaincast;
 
 class formHandler extends abstractMaincast
 {  
    public function __construct($title, $category, $stage, $pool, $live, $beginning, $ending, $description, $url, $id=null)
    {
        
        $this->title = $title;
        $this->category = $category;
        $this->stage = $stage;
        $this->pool = $pool;
        $this->live = $live;
        $this->beginning = $beginning;
        $this->ending = $ending;
        $this->description = $description;
        $this->url = $url;
        $this->id = $id;     
             
        $this->cleanInputFromXSS();
        $this->validateInput($this->title, $this->stage, $this->pool, $this->beginning, $this->ending, $this->description, $this->url);
       
    }
    private function cleanInputFromXSS()
    {
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->stage = htmlspecialchars(strip_tags($this->stage));
        $this->pool = htmlspecialchars(strip_tags($this->pool));
        $this->beginning = htmlspecialchars(strip_tags($this->beginning));
        $this->ending = htmlspecialchars(strip_tags($this->ending));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->url = htmlspecialchars(strip_tags($this->url));
    }
    protected function validateInput($title, $stage, $pool, $beginning, $ending, $description, $url)
    {
        //Повідомлення про помилку у разі якщо не введено даних в одному з полів
        if (empty($title)) {
            throw new \Exception("Назава обовязкова.");
        }
        if (empty($stage)) {
            throw new \Exception("Введіть стадію турніру.");
        }
        if (empty($pool)) {
            throw new \Exception("Введіть винагороду турніру");
        }
        if (!is_numeric($pool)) {
            throw new \Exception("Винагорода в числовому значенні");
        }  
        if (empty($beginning)) {
            throw new \Exception("Введіть початок турніру.");
        }
        if (empty($ending)) {
            throw new \Exception("Введіть закінчення турніру.");
        }
        if (empty($description)) {
            throw new \Exception("Введіть короткий опис турніру.");
        }
        if (empty($url)) {
            throw new \Exception("Введіть ваше посилання.");
        }
    }
      

    //функція на збереження в базу даних
    public function saveDb()
    {
        $dbConection = Database::getInstance()->getConection();
        
        $stmt = $dbConection->prepare("INSERT INTO ads (title, category, stage, pool, live, beginning, ending, description, url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssisssss', $this->title, $this->category, $this->stage, $this->pool, $this->live, $this->beginning, $this->ending, $this->description, $this->url);
        if (!$stmt->execute()) {
        throw new \Exception("Помилка завантаження в базу даних");
        }
        $this->id = $stmt->insert_id;
    }

    //Запит на вивід оголошення по номеру id
    public static function fetchById($id)
    {   
        
        $dbConection = Database::getInstance()->getConection();
        $stmt = $dbConection->prepare("SELECT * FROM ads WHERE id = ?");
        if ($stmt === false) {
            throw new \Exception("Помилка підготовки запиту до бази даних!");
        }

        $stmt->bind_param('i', $id);
        
        if (!$stmt->execute()) {
            throw new \Exception("Помилка отримання оголошення з бази даних");
        }
     
        $result = $stmt->get_result();
        $ad = $result->fetch_assoc();

        if ($ad === null)
        {
            throw new \Exception("Турнір з id = {$id} не знайдено");
        }
        $category  = Category::fetchById($ad['category']); 
        $ad['category_name'] = !empty($category) ? $category['name'] : null;

       
        return $ad;
    }
    public static function deleteById($id)
    {
        $ad = self::fetchById($id);
        $dbConection = Database::getInstance()->getConection();

        $stmt = $dbConection->prepare("DELETE FROM ads WHERE id = ?"); 
        $stmt->bind_param('i', $id);
        if ($stmt->execute() === false) {
            throw new \Exception("Помилка видалення оголошення з бази даних");
        }

        
        
    }
    
    public static function fetchAll()
    {
        $dbConection = Database::getInstance()->getConection();

        $stmt = $dbConection->query("SELECT * FROM ads");

        if ($stmt === false) {
            throw new \Exception("Помилка отримання оголошень з бази даних");
        }
        
        $ads = $stmt->fetch_all(MYSQLI_ASSOC);
        foreach ($ads as $ad) {
            $category = Category::fetchById($ad['category']);
            $ad['category_name'] = !empty($category) ? $category['name'] : null;
        }

        return $ads;

    } 
    public static function updateById($id, $title, $category, $stage, $pool, $live, $beginning, $ending, $description, $url)
    {
        $ad = self::fetchById($id);
        $dbConection = Database::getInstance()->getConection();

        $stmt = $dbConection->prepare("UPDATE ads SET title = ?, category = ?, stage = ?, pool = ?, live = ?, beginning = ?, ending = ?, description = ?, url = ? WHERE id = ?");
        $stmt->bind_param('sssisssssi', $title, $category, $stage, $pool, $live, $beginning, $ending, $description, $url, $id);
        if (!$stmt->execute()) {
         throw new \Exception("Помилка редагування оголошення");
        }
        return $ad;
    }
    public static function fetchLive()
{
    $dbConection = Database::getInstance()->getConection();
    $stmt = $dbConection->query("SELECT * FROM ads WHERE live = 1");

    if ($stmt === false) {
        throw new \Exception("Помилка отримання оголошень з бази даних");
    }

    $ads = $stmt->fetch_all(MYSQLI_ASSOC);
    foreach ($ads as $ad) {
        $category = Category::fetchById($ad['category']);
        $ad['category_name'] = !empty($category) ? $category['name'] : null;
    }

    return $ads;
}
 }

