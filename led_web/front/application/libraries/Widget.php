<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Widget library.
 */
class Widget_Core {
    
	protected $name             = '';
	protected $style            = 'classic';
	protected $data             = array();

	/**
	 * Constructs and returns a new Widget object.
	 *
	 * @param   string      widget name
	 * @param   array       data
	 * @return  object
	 */
	public function factory($widget,$data=array())
	{
		return new Widget($widget,$data);
	}

	/**
	 * Constructs a new Pagination object.
	 *
	 * @param   string      widget name
	 * @param   array       data
	 * @return  void
	 */
	public function __construct($widget,$data=array())
    {
        $this->name         = $widget;
        $this->data         = $data;
	}


	/**
	 * Generates the HTML for the chosen widget style.
	 *
	 * @param   string  widget style
	 * @return  string  if print is FALSE
	 * @return  void    if print is TRUE
	 */
	public function render($style = NULL,$print=TRUE)
    {
        if($style)
        {
            $this->style  = $style;
        }
        return ;
		// Buffering on
		ob_start();

		// Import the view variables to local namespace
		extract($this->data, EXTR_SKIP);

		try
        {
            $theme_id = 1;//Mysite::instance()->get('theme');
            $file = array();
            $file[] = DOCROOT . 
                'themes' . DIRECTORY_SEPARATOR .
                $theme_id.DIRECTORY_SEPARATOR .
                'widget_'.$this->name.'_'.$this->style.'.php';
            //默认风格文件
            $file[] = DOCROOT . 
                'themes' . DIRECTORY_SEPARATOR .
                '0'.DIRECTORY_SEPARATOR .
                'widget_'.$this->name.'_'.$this->style.'.php';
            //默认文件
            $file[] = DOCROOT . 
                'themes' . DIRECTORY_SEPARATOR .
                '0'.DIRECTORY_SEPARATOR .
                'widget_'.$this->name.'_classic.php';
            foreach($file as $_file)
            {
                if(file_exists($_file))
                {
                    $view_file = $_file;
                    break;
                }
            }
            
            include $view_file;
        }
        catch (Exception $e)
        {
            ob_end_clean();
            throw $e;
        }

        //模版输出
        if($print)
        {
		    echo ob_get_clean();
        }
        else
        {
		    return ob_get_clean();
        }
    }

    /**
     * Magically converts Pagination object to string.
     *
     * @return  string  pagination html
     */
    public function __toString()
    {
        return $this->render('classic',FALSE);
    }


} // End Pagination Class
