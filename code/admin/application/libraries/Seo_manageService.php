<?php
defined('SYSPATH') or die('No direct access allowed.');

class Seo_manageService_Core extends DefaultService_Core{
	const SEO_CATEGORY_IS_NOT_CHILDREN = 0; // 不包含子分类
	const SEO_CATEGORY_IS_CHILDREN = 1; // 包含子分类
	const SEO_CATEGORY_IS_NULL = 0; // 分类是否是默认
	

	/* 兼容php5.2环境 Start */
	private static $instance = NULL;

	// 获取单态实例
	public static function get_instance()
	{
		if(self::$instance === null){
			$classname = __CLASS__;
			self::$instance = new $classname();
		}
		return self::$instance;
	}

	/**
	 * 根据category_id和site_id得到配置的seo全局信息模板
	 *
	 * @param int $site_id
	 * @param int $category_id
	 * @return array
	 */
	public function get_by_category_id($category_id = 0)
	{
		$seo_manage = ORM::factory('seo_manage')->where('category_id',$category_id)
			->find();
		return $seo_manage->as_array();
	}

	/**
	 * 根据产品ID得到产品的SEO信息结构
	 * @param int $id product id
	 * @return array
	 */
	public function get_product_seo_struct_by_product_id($id = 0)
	{
		if($id < 1){
			return false;
		}
		
		$return_data = array();
		$product = ProductService::get_instance()->get($id);
		if(!empty($product['id'])){
			$category = CategoryService::get_instance()->get($product['category_id']);
			$site = Mysite::instance($product['site_id'])->get();
			$param = array(
				'category_id' => $category['id'], 
				'product_name' => $product['title'], 
				'category_name' => $category['title'], 
				'site_domain' => $site['domain'], 
				'goods_price' => $product['goods_price']
			);
			return $this->get_product_seo_struct($site['id'],$param);
		}
	}

	/**
	 * 提供可变换的变量得到商品的SEO信息 
	 * @param int $site_id
	 * @param array $param('category_id','product_name','category_name','site_domain','goods_price') 可替换内容
	 * @return array
	 */
	public function get_product_seo_struct($site_id = 0,$param = array())
	{
		$return_data = array(
			'meta_title' => '', 
			'meta_keywords' => '', 
			'meta_description' => ''
		);
		
		if($site_id <= 0)
		{
			return $return_data;
		}
			
		$category_id = (!empty($param['category_id'])) ? $param['category_id'] : 0;
		
		$product_name = (!empty($param['product_name'])) ? $param['product_name'] : '';
		$category_name = (!empty($param['category_name'])) ? $param['category_name'] : '';
		$site_domain = (!empty($param['site_domain'])) ? $param['site_domain'] : '';
		$goods_price = (!empty($param['goods_price'])) ? $param['goods_price'] : 0;
		
		$seo_manager = $this->get_by_category_id($category_id);
		/* 读取不到当前分类的读取全局的 */
		if($category_id > 0 && (empty($seo_manager) || $seo_manager['id'] < 1))
		{
			$seo_manager = $this->get_by_category_id();
		}
		
		if(is_array($seo_manager) && count($seo_manager) > 0)
		{
			$meta_title = $seo_manager['meta_title'];
			$meta_keywords = $seo_manager['meta_keywords'];
			$meta_description = $seo_manager['meta_description'];

			$title = str_replace('{product_name}',$product_name,$meta_title);
			$keywords = str_replace('{product_name}',$product_name,$meta_keywords);
			$description = str_replace('{product_name}',$product_name,$meta_description);
			
			$title = str_replace('{category_name}',$category_name,$title);
			$keywords = str_replace('{category_name}',$category_name,$keywords);
			$description = str_replace('{category_name}',$category_name,$description);
			
			$title = str_replace('{site_domain}',$site_domain,$title);
			$keywords = str_replace('{site_domain}',$site_domain,$keywords);
			$description = str_replace('{site_domain}',$site_domain,$description);
			
			$title = str_replace('{price}',$goods_price,$title);
			$keywords = str_replace('{price}',$goods_price,$keywords);
			$description = str_replace('{price}',$goods_price,$description);
		}
		
		$return_data['meta_title'] = $title;
		$return_data['meta_keywords'] = $keywords;
		$return_data['meta_description'] = $description;
		
		return $return_data;
	}

	/**
	 * 根据 site_id 获取该  seo_manage 中所有的seo数据
	 *
	 * @param $site_id  int
	 * @return array
	 */
	public function get_seo_by_site_id($site_id)
	{
		$results = array();
		$query_struct = array(
			'where' => array(
				'site_id' => $site_id
			)
		);
		$result = $this->query_assoc($query_struct);
		if(!empty($result)){
			foreach($result as $key=>$val){
				$results[] = $val;
			}
		}
		return $results;
	}
}
