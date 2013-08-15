<?php defined('SYSPATH') OR die('No direct access allowed.');

class Xml_Core {
	
	/* 提供参数获取xml里面的数据
	 * 
	 * string $path  路径
	 * string $tagname 标记名称 
	 * string $param  筛选记录的值
	 * array $array  返回的参数
	 * return array
	 */
	public static function parse($path, $tagname, $array, $param = '')
	{
		$returns = array();
		if(!file_exists($path))
		{
			exit('路径不存在！');
		}
		if(tool::fileext($path) == 'xml')
		{
			exit('需要解析的文件必须是xml格式的！');
		}
		$xml = new DOMDocument();
		$xml->load($path);
		$root = $xml->documentElement;
		$data = $xml->getElementsByTagName("{$tagname}");
		foreach($data as $val)
		{
			if(strlen($param) > 0)
			{
				if($val->getAttribute('id') == $param)
		     	{
		     		if(is_array($array) && count($array) > 0)
		     		{
		     			foreach($array as $key=>$arr)
		     			{
		     				$returns[$arr] = $val->getElementsByTagName("{$arr}")->item(0)->nodeValue;
		     			}	     			
		     		}
		     		else
		     		{
		     			return array();
		     		}
		     		break;
				}
			}
			else
			{
				if(is_array($array) && count($array) > 0)
		     	{
		     		foreach($array as $key=>$arr)
		     		{
		     			$return[$arr] = $val->getElementsByTagName("{$arr}")->item(0)->nodeValue;
		     		}	     			
		     	}
		     	else
		     	{
		     		return array();
		     	}
		     	$returns[] = $return;
			}	     	
	     }
	     return $returns;	
	}
	
	
	/* 将数组中的数据生成xml文件
	 * 
	 * array $arr 需要转换的数组key value对应xml里面的属性和值
	 * string $name xml文件的名称
	 * string $tag 是否存在id对应的字段
	 */
	public static function build_xml($arr, $name, $tag = '')
	{
		$xml = new DOMDocument('1.0', 'utf-8');                // 声明版本和编码
		$xml->formatOutput = true;                             //格式XML输出
		$root    = $xml->createElement('root');                //创建一个标签
		if (is_array($arr) && count($arr) > 0)
		{
			foreach($arr as $key => $value)
			{
				$index = $xml->createElement("{$name}");       //创建一个标签
				if(is_array($value) && count($value))
				{
					foreach($value as $k=>$v)
					{
						$node     = $xml->createElement("{$k}");
						$nodeValue = $xml->createTextNode("{$v}");
						if(!empty($tag) && $k == $tag)
						{
							$tagValue = $v;
						}
						$node->appendChild($nodeValue);
						$index->appendChild($node);
					}
				}
				else
				{
					return false;
				}
				if($tag)
				{
					$id      = $xml->createAttribute('id');            //创建一个属性
					$idValue = $xml->createTextNode("{$tagValue}");    //设置属性内容
					$id->appendChild($idValue);
					$index->appendChild($id);
				}
				$root->appendChild($index); 
			}
		}
		else
		{
			return false;
		}
		$xml->appendChild($root);
		$xml->save("{$name}.xml");                                        // 生成保存为XML
		return true;
	} 
}