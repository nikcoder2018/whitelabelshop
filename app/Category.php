<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    protected $fillable = ['name', 'slug', 'description', 'image', 'icon', 'parent', 'status'];

    function productcategory(){
        return $this->hasMany(ProductCategory::class);
    }

    function scopeBuildTree($query, array $elements, $parentId = 0) {
        $branch = array();  
        
        foreach ($elements as $element) {
            if ($element['parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                
                if ($children) {
                    $element['children'] = $children;
                }
                
                $branch[] = $element;
            }
        }
        
        return $branch;
    }

    function scopeBuildTreeHTML($query, array $elements, $parentId = 0) {
        $html = '';

        foreach ($elements as $element) {
            if ($element['parent'] == $parentId) {
                $children = $this->buildTreeHTML($elements, $element['id']);
                
                if ($children != '') {
                    $html .= "
                            <div class='tree-folder'>
                                <div class='tree-folder-header'>
                                    <i class='fa fa-folder'></i>
                                    <div class='tree-folder-name'>
                                        {$element['name']} <div class='tree-actions'><i class='fa fa-edit edit-category' data-id='{$element['id']}'></i><i class='fa fa-trash-o delete-category' data-id='{$element['id']}'></i></div>
                                    </div>
                                </div>
                                <div class='tree-folder-content' style='display:none;'>
                                    {$children}
                                </div>
                                <div class='tree-loader'></div>
                            </div>
                            ";
                }else{
                    $html .= "<div class='tree-item'>
                                <i class='tree-dot'></i>
                                <div class='tree-item-name'>
                                    {$element['name']} <div class='tree-actions'><i class='fa fa-edit edit-category' data-id='{$element['id']}'></i><i class='fa fa-trash-o delete-category' data-id='{$element['id']}'></i></div>
                                </div>
                            </div>";
                }

            }
        }
        
        return $html;
    }

    function scopeBuildTreeHTML2($query, array $elements, $parentId = 0, $selected = array()) {
        $html = '';

        foreach ($elements as $element) {
            if ($element['parent'] == $parentId) {
                $children = $this->buildTreeHTML2($elements, $element['id'], $selected);
                
                if ($children != '') {
                    $checked = '';
                    if($selected){
                        foreach($selected as $category){
                            if($category->category_id == $element['id']){
                                $checked = 'checked';
                            }
                        }
                    }
                    $html .= "<li class='mb-1'>
                                <div class='form-check'>
                                    <input type='checkbox' name='categories[]' {$checked} value='{$element['id']}' class='form-check-input' id='categoryCheck{$element['id']}'>
                                    <label class='form-check-label' for='categoryCheck{$element['id']}'>{$element['name']}</label>
                                </div>
                                    <ul class='children'>
                                        {$children}
                                    </ul>
                                </li>";
                }else{
                    $checked = '';
                    if($selected){
                        foreach($selected as $category){
                            if($category->category_id == $element['id']){
                                $checked = 'checked';
                            }
                        }
                    }

                    $html .= "<li class='mb-1'>
                                <div class='form-check'>
                                    <input type='checkbox' name='categories[]' {$checked} value='{$element['id']}' class='form-check-input' id='categoryCheck{$element['id']}'>
                                    <label class='form-check-label' for='categoryCheck{$element['id']}'>{$element['name']}</label>
                                </div>
                             </li>";
                }

            }
        }
        
        return $html;
    }
}
