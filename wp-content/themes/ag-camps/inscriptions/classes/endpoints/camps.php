<?php
namespace Agcsi\Endpoints;

class CampsEndpoint {

    public static function response($data, $post, $context ){
        return [
            'resourceId'=>$post->ID,
            'title'=>$post->post_title,
            'start'=>date_i18n('c',strtotime('+1 hour',strtotime(get_field('date_de_debut',$post)))),
            'end'=>date_i18n('c',strtotime('+1 hour',strtotime(get_field('date_de_fin',$post)))),
            'color'=>get_field('couleur',$post),
            'borderColor'=>get_field('couleur',$post),
            'description'=>get_field('description',$post),
            'url'=>get_the_permalink($post)
        ];
    }

    public static function collection_params( $query_params ) {
        $query_params['start'] = [
            'description' => __( 'Limit response to posts published after a given ISO8601 compliant date.' ),
            'type'        => 'string',
            'format'      => 'date-time',
        ];
        $query_params['end'] = [
            'description' => __( 'Limit response to posts published before a given ISO8601 compliant date.' ),
            'type'        => 'string',
            'format'      => 'date-time',
        ];
        return $query_params;
    }

    public static function query( $args, $request ) {
        if(isset( $request['start'])){
            $args['meta_query'][] = [
                'key'=>'date_de_debut',
                'type'=>'DATETIME',
                'value'=>$request['start'],
                'compare'=>'>='
            ];
        }
        if(isset( $request['end'])){
            $args['meta_query'][] = [
                'key'=>'date_de_fin',
                'type'=>'DATETIME',
                'value'=>$request['end'],
                'compare'=>'<'
            ];
        }
        if(isset( $request['end']) && isset( $request['start'])){
            $args['meta_query']['relation'] = 'AND';
        }
    
        return $args;
    }
   
    public static function register(){
        add_filter( 'rest_prepare_camps', __NAMESPACE__ .'\CampsEndpoint::response', 10, 3 );
        add_filter( 'rest_camps_collection_params', __NAMESPACE__ .'\CampsEndpoint::collection_params', 10, 3 );
        add_filter( 'rest_camps_query', __NAMESPACE__ .'\CampsEndpoint::query' , 10, 2 );
    }
}


