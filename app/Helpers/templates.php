<?php
function sectionTemplate($id){
    $section = \App\Section::where('id', $id)->with(['blocks.inputs'])->first();
    $response = array();
    if($section && $section->blocks){
        foreach($section->blocks as $block){
            $sections = collect();
            if($block->inputs){
                foreach($block->inputs as $input){
                    $sections->put($input->name, $input->value);
                }
                array_push($response, $sections);
            }
        }
    }
    return $response;
}