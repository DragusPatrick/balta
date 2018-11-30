<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assets
{
    protected $js_files     = array();

    protected $css_files    = array();

    public function __get($var)
    {
        return get_instance()->$var;
    }

    public function add_js($src = '', $type = 'text/javascript', $charset = false, $defer = false, $async = false)
    {
        if(!is_array($src))
        {
            $src = array(
                'type' => $type,
                'src'  => $src
            );

            if($charset)
                $src['charset'] = $charset;

            if($defer)
                $src['defer'] = $defer;

            if($async)
                $src['async'] = $async;
        }


        if(isset($src['src']))
        {
            $js = array(
                'type' => isset($src['type']) ? $src['type'] : 'text/javascript',
                'src'  => preg_match('#^([a-z]+:)?//#i', $src['src']) ? $src['src'] : $this->config->base_url($src['src'])
            );

            unset($src['src'], $src['type']);

            if(count($src) > 0)
            {
                foreach($src AS $attr_key => $attr_val)
                {
                    $js[] = array($attr_key => $attr_val);
                }
            }

            $this->js_files[] = $js;
        }

        return $this;
    }

    public function add_css($href = '', $rel = 'stylesheet', $type = 'text/css', $media = 'all')
    {
        if(!is_array($href))
        {
            $href = array(
                'rel'   => $rel,
                'type'  => $type,
                'href'  => $href,
                'media' => $media
            );
        }

        if(isset($href['href']))
        {
            $css = array(
                'rel'   => isset($href['rel']) ? $href['rel'] : 'stylesheet',
                'type'  => isset($href['type']) ? $href['type'] : 'text/css',
                'href'  => preg_match('#^([a-z]+:)?//#i', $href['href']) ? $href['href'] : $this->config->base_url($href['href']),
                'media' => isset($href['media']) ? $href['media'] : 'all'
            );

            unset($href['href'], $href['type'], $href['rel'], $href['media']);

            if(count($href) > 0)
            {
                foreach($href AS $attr_key => $attr_val)
                {
                    $css[] = array($attr_key => $attr_val);
                }
            }

            $this->css_files[] = $css;
        }

        return $this;
    }

    public function output_js()
    {
        $output_js = '';

        foreach($this->js_files AS $js_attributes)
        {
            $output_js .= "<script";

            foreach($js_attributes AS $attr_key => $attr_val)
            {
                $output_js .= " " . $attr_key . "=\"" . $attr_val . "\"";
            }

            $output_js .= "></script>\n";
        }

        return $output_js;
    }

    public function output_css()
    {
        $output_css = '';

        foreach($this->css_files AS $css_attributes)
        {
            $output_css .= "<link";

            foreach($css_attributes AS $attr_key => $attr_val)
            {
                $output_css .= " " . $attr_key . "=\"" . $attr_val . "\"";
            }

            $output_css .= " />\n";
        }

        return $output_css;
    }
}