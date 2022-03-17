<?php

class SeparatedQuery extends WP_Query {

    protected $separator;

    protected $labelFormatter;

    public function __construct($query = '', $separator, $labelFormatter = null) {
        parent::__construct($query);
        $this->setSeparator($separator);
        $this->setLabelFormatter($labelFormatter);
    }

    public function setSeparator(Closure $separator) {
        $this->separator = $separator;
    }

    public function setLabelFormatter(Closure $labelFormatter) {
        $this->labelFormatter = $labelFormatter;
    }

    public function willSeparate() {
        $posts = $this->posts ?? $this->get_posts();
        $separator = $this->separator;
        $nextPost = false;

        foreach ($posts as $post) {
            if ($nextPost) {
                $nextPost = $post;
                break;
            }

            $nextPost = $post->ID === get_the_ID();
        }

        return gettype($nextPost) !== gettype(true) && $separator && $separator(get_post(), $nextPost);
    }

    public function getSeparatorLabel() {
        if($formatter = $this->labelFormatter) {
            return $formatter($this->post);
        }

        return '';
    }

}
