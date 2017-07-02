<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Product;

/**
 * Class ProductsController
 * @package App\Controllers
 */
class ProductsController extends \Core\Controller
{
    public function indexAction()
    {
        if (isset($_POST) && !empty($_POST)) {

            Product::setProduct($_POST);

            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

        $list =  Product::getAll();

        View::renderTemplate('Product/index.html.twig', [
            'list'  => json_encode($list, JSON_PRETTY_PRINT),
        ]);
    }

    public function listAction()
    {
        $length = (isset($_POST['length'])) ? $_POST['length'] : 20;
        $start  = (isset($_POST['start'])) ? $_POST['start'] : 0;
        $dir    = (isset($_POST['order']['0']['dir'])) ? $_POST['order']['0']['dir'] : 'asc';

        if(isset($_POST['order'])){
            switch ($_POST['order']['0']['column']) {
                case '0' : $orderBy = 'id'; break;
                case '1' : $orderBy = 'title'; break;
                case '2' : $orderBy = 'description'; break;
                case '3' : $orderBy = 'price'; break;
                case '4' : $orderBy = 'weight'; break;
                case '5' : $orderBy = 'width'; break;
                case '6' : $orderBy = 'height'; break;
                default  : $orderBy = 'id';
            }
        }else{
            $orderBy = 'id';
        }

        $total  = Product::getAll();
        $list   = Product::getProducts($orderBy, $dir, $start, $length);

        $forming = [
            "draw"              => (isset($_POST['draw']) && !empty($_POST['draw'])) ? $_POST['draw'] : '',
            "recordsTotal"      => count($total),
            "recordsFiltered"   => count($total),
            "data"              => $list
        ];

        echo json_encode($forming, JSON_PRETTY_PRINT);
    }

    public function delAction()
    {
        foreach ($_POST['data'] as $key)
            Product::removeProducts($key);

        echo 'ok';
    }
}
