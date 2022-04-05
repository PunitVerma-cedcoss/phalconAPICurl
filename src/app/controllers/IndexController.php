<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
        $this->assets->addCss('css/styles.css');
        //load the search component
        $search = new App\Components\SearchComponent();
        if ($this->request->isPost()) {
            $data = $search->search($this->request->getPost()['search']);
            // pass data into view
            $this->view->data = $data;
            $this->view->query = $this->request->getPost()['search'];
        }
    }
    public function bookAction()
    {
        $this->assets->addCss('css/styles.css');
        $id = $this->request->getQuery()["id"];
        if (!isset($id)) {
            header("location:/");
        }
        //fetch the book content here
        $search = new App\Components\SearchComponent();
        $data = $search->getBookById($id);
        $image = explode("/", $data['ISBN:' . $id]["preview_url"])[4];
        $this->view->data = $data['ISBN:' . $id];
        $this->view->image = "https://covers.openlibrary.org/b/olid/{$image}-L.jpg";
    }
}
