<?php
require 'db.php';

if (!R::testConnection())
    exit ('Нет соединения с базой данных');

class ProductInfo
{
    public $books;
    public $info;

    public function __construct()
    {
        $this->info = null;
        $this->books = R::findAll('books');
        $this->booksArray = array();
        $this->Getbooks();
    }

    private function Getbooks()
    {
        if(!empty($this->books))
        {
            $n = 0;

            foreach ($this->books as $item)
            {
                $id = $item->id;
                $title = $item->title;
                $author_name = $item->author_name;
                $img = explode('|' ,$item->img);

                        $this->booksArray[$n] = " <div class=\"col-lg-3 mb-4 div-column-style\">
                    <a href=\"$img[0]\">
                        <img src=\"$img[0]\" class=\"img-thumbnail zoom\" style=\"background-color: grey; width: 304px; height:236px\" alt=\"Image\" width=\"304px\" height=\"236px\">
                        <div class=\"caption text-primary\">
                            <form method=\"GET\" action=\"phpScripts/action.php\">
                            <input name=\"id\" value=\"$id\" type=\"hidden\">
                            
                            <p>$title $author_name</p>
                            <hr>
                           
                             </a>
                            <button type=\"submit\" class=\"btn btn-outline-primary btn-block\" \">Watch more info</button>
                            </form>
                           
                        </div>
                   
                </div>";
                        $n++;
                }
            }
        }


}