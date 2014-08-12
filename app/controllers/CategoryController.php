<?php

use Scrib\Repo\Category\CategoryInterface;
use Scrib\Service\Form\Category\CreateCategoryForm;

class CategoryController extends \BaseController {

    protected $category;
    protected $createForm;

    public function __construct(CategoryInterface $category, CreateCategoryForm $createForm)
    {
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
        $this->category = $category;
        $this->createForm = $createForm;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = $this->category->all();

        return View::make('admin.category.index')->with('categories', $categories);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.category.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = array_merge(Input::all(), array('cover' => Input::file('cover')));


        if ($this->createForm->save($input))
        {
            return Redirect::route('admin.category.index')->with('flash_message', 'Category created successfully');
        }

        return Redirect::back()->withErrors($this->createForm->errors())->withInput();
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return $this->edit($id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->category->byId($id);

        return View::make('admin.category.edit', compact('category'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $added = array(
            'id'    => $id,
            'cover' => Input::file('cover')
        );

        $input = array_merge(Input::all(), $added);

        if ( ! $this->createForm->update($input))
        {
            return Redirect::back()->withErrors($this->createForm->errors())->withInput();
        }

        return Redirect::route('admin.category.index')->with('flash_message', 'Category updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
