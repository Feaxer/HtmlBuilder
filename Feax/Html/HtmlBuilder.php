<?php 
namespace Feax\Html;

class HtmlBuilder {
    
    protected $unpaired = [
        "br",
        "hr",
        "input",
        "img",
        "link",
        "area",
        "base",
        "col",
        "frame",
        "meta",
        "param"
    ];
    
    public function entities($var)
	{
		return htmlentities($var, ENT_QUOTES, 'UTF-8', false);
	}
	
	public function tag($name, $attributes = array(), $inner = null, $encode = true) {
	    if (null !== $inner && $encode) $inner = $this->entities($inner);

	    if (!in_array(strtolower($name), $this->unpaired))
	        return '<'.$name.$this->attributes($attributes).'>'.$inner.'</'.$name.'>';
	    else
	        return '<'.$name.$this->attributes($attributes).'>';
	}
    
    public function attributes($attributes) {
        $pairs = array();
        
        foreach ((array)$attributes as $name => $value) {
            if (is_numeric($name)) 
                $name = $value;
            
            if (null !== $value) 
                $pairs[] = $name.'="'.$value.'"'; 
        }
        
        return count($pairs) > 0 ? ' '.implode(' ', $pairs) : '';
    }
    
	public function script($url, $attributes = array())	{
		$attributes['src'] = $url;
		return $this->tag("script", $attributes).PHP_EOL;
	}
	
	public function style($url, $attributes = array()) {
	    $attributes['href'] = $url;
	    $attributes += array('media' => 'all', 'rel' => 'stylesheet', 'type' => 'text/css');
	    return $this->tag("link", $attributes).PHP_EOL;
	}
	
	public function image($url, $alt = null, $attributes = array()) {
	    $attributes['alt'] = $alt;
	    $attributes['src'] = $url;
	    return $this->tag("img", $attributes);
	}
	
	public function link($url, $title = null, $attributes = array(), $encode = true) {
	    if (null === $title || false === $title) $title = $url;
	    $attributes['href'] = $url;
	    return $this->tag("a", $attributes, $title, $encode);
	}
	
	public function div($inner, $attributes = array(), $encode = false) {
	    return $this->tag("div", $attributes, $inner, $encode);
	}
	
	public static function __callStatic($name, $args) {
	    
	}
}