<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class StringComponent extends Component {
    public function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    public function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }   
}
?>