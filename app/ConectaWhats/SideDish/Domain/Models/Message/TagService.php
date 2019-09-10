<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 01/12/2018
 * Time: 18:08
 */

namespace App\ConectaWhats\SideDish\Domain\Models\Message;


class TagService
{
    private $tags;
    private $values;
    private $isSingular;
    const REGEX_FLEXION = "/\[[a-z]*\|[a-z]*\]/i";

    public function __construct(array $data, $isSingular = true)
    {
        $this->setTags($data);
        $this->setValues($data);
        $this->isSingular = $isSingular;
    }

    protected function setTags($data)
    {
        $this->tags = array_keys($data);
    }

    protected function setValues($data)
    {
        $this->values = array_values($data);
    }

    public function transformText($textBody)
    {
        preg_match_all(self::REGEX_FLEXION, $textBody, $matches);

        foreach($matches[0] as $match){
            $this->setFlexion($match);
        }

        return preg_replace($this->getArrayPatterns(), $this->values, $textBody);
    }

    protected function setFlexion($tag)
    {
        $explode = explode("|", $tag);
        if($this->isSingular){
            $this->setValue($tag, $this->removeBrakets($explode[0]));
        }else{
            $this->setValue($tag, $this->removeBrakets($explode[1]));
        }
    }

    protected function removeBrakets($value)
    {
        return preg_replace(["/\[/", "/\]/"], "", $value);
    }


    protected function setValue($tag, $value)
    {
        $this->tags[] = $tag;
        $this->values[] = $value;
    }

    protected function getArrayPatterns()
    {
        $patterns = [];
        foreach($this->tags as $tag){
            $patterns[] = "/" . preg_quote($tag) . "/";
        }
        return $patterns;
    }
}