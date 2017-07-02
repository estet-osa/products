<?php

namespace App\Models;

use PDO;

class Product extends \Core\Model
{
    public static function setProduct(Array $params)
    {
        $db = static::getDB();

        $id          = strip_tags(trim((int)$params['id']));
        $title       = strip_tags(trim($params['title']));
        $description = strip_tags(trim($params['description']));
        $price       = strip_tags(trim($params['price']));
        $weight      = strip_tags(trim($params['weight']));
        $width       = strip_tags(trim($params['width']));
        $height      = strip_tags(trim($params['height']));

        $sqlInsert = "INSERT INTO products (title, description, price, weight, width, height) VALUES ('{$title}', '{$description}', '{$price}', '{$weight}', '{$width}', '{$height}')";
        $sqlUpdate = "UPDATE products SET title = '{$title}', description = '{$description}', price = '{$price}', weight = '{$weight}', width = '{$width}', height = '{$height}' WHERE id = '{$id}'";

        if((int)($id))
            return $db->query($sqlUpdate);
        else
            return $db->query($sqlInsert);
    }

    public static function getAll()
    {
        $db     = static::getDB();
        $stmt   = $db->query('SELECT * FROM products');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProducts($orderBy, $dir, $start, $length = 20)
    {
        $db     = static::getDB();

        $sql = "SELECT id as DT_RowId, title, description, price, weight, width, height FROM products
                  ORDER BY {$orderBy} {$dir} LIMIT {$start}, {$length}";

        $res = $db->query($sql);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function removeProducts($id)
    {
        $db  = static::getDB();
        $sql = "DELETE FROM products WHERE id = {$id}";

        return $res = $db->query($sql);
    }
}
