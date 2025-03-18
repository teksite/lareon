<?php
//$permissions = \Teksite\Authorize\Models\Permission::query()->get(['title','id'])->pluck('title','id')->toArray();
//
//function buildTree($permissions)
//{
//    $tree = [];
//    foreach ($permissions as $permission) {
//
//        $parts = explode('.', $permission);
//        $current = &$tree;
//        foreach ($parts as $part) {
//            if (!isset($current[$part])) {
//                $current[$part] = [];
//            }
//            $current = &$current[$part];
//        }
//    }
//    return $tree;
//}
//
//function renderTree($tree, $prefix = '')
//{
//    echo "<ul>";
//    foreach ($tree as $key => $subtree) {
//        $fullPath = ltrim("$prefix.$key", '.');
//        echo "<li>$fullPath";
//        if (empty($subtree)) {
//            echo " <input type='checkbox' name='permissions[]' value='$fullPath'>";
//        }
//        renderTree($subtree, $fullPath);
//        echo "</li>";
//    }
//    echo "</ul>";
//}
//
//$tree = buildTree($permissions);
//dd(renderTree($tree));
