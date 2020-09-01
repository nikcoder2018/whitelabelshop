<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $data['categories_tree'] = $this->buildTreeHTML($categories->toArray());
        $data['categories'] = $categories;

        return view('admin.contents.categories', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->parent = $request->parent;
        $category->save();

        if($category){
            $categories = Category::all();
            $html_build_tree = $this->buildTreeHTML($categories->toArray());
            return response()->json(array('success' => true, 'msg' => 'Category added successfully.', 'html_build' => $html_build_tree));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCategoriesJSON(){
        $categories = Category::all()->toArray();

        $array_categories = $this->buildTreeHTML($categories);

        return response()->json($array_categories);
    }

    function buildTree(array $elements, $parentId = 0) {
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

    function buildTreeHTML(array $elements, $parentId = 0) {
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
                                        {$element['name']} <div class='tree-actions'><i class='fa fa-edit'></i><i class='fa fa-trash-o'></i></div>
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
                                    {$element['name']} <div class='tree-actions'><i class='fa fa-edit'></i><i class='fa fa-trash-o'></i></div>
                                </div>
                            </div>";
                }

            }
        }
        
        return $html;
    }
}
