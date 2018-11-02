<?php

namespace App\Olify\Marketify\Repositories;

use App\Olify\Marketify\Category;
use App\Olify\Marketify\Exceptions\CreateCategoryErrorException;
use App\Olify\Marketify\Exceptions\CategoryNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;


class CategoryRepository
{
	
	protected $mode;
	/**
     * CategoryRepository constructor.
     * @param Category $category
     */
	function __construct(Category $category)
	{
		$this->model = $category;
	}

	/**
     * @param array $data
     * @return Category
     * @throws CreateCategoryErrorException
     */
    public function createCategory(array $data) : Category
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {
            throw new CreateCategoryErrorException($e);
        }
    }

    /**
     * @param int $id
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function findCategory(int $category_id) : Category
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e);
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws UpdateCategoryErrorException
     */
    public function updateCategory(array $data) : bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new UpdateCategoryErrorException($e);
        }
    }

    /**
    * @return bool
    */
    public function deleteCategory() : bool
    {
        return $this->model->delete();
    }
}
?>