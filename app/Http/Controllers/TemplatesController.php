<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

// Models
use App\Template;
use App\Page;
use App\Section;
use App\Block;
use App\BlockInput;

class TemplatesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $templates = Template::with(['pages.sections.blocks.inputs'])->get();
        // return $templates;
        return view('templates.index', compact('templates'));
    }

    public function template_create(Request $request){
        DB::beginTransaction();
        try {
            $template = Template::create([
                'name' => $request->name,
                'description' => $request->description
            ]);

            DB::commit();
            return redirect('admin/templates')->with(['type' => 'success', 'message' => 'Registro agregado exitosamenete.']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('admin/templates')->with(['type' => 'error', 'message' => 'Ocurrio un error.']);
        }
    }

    public function page_create(Request $request){
        DB::beginTransaction();
        try {
            $template = Page::create([
                't_template_id' => $request->template_id,
                'name' => $request->name,
                'description' => $request->description
            ]);

            DB::commit();
            return redirect('admin/templates')->with(['type' => 'success', 'message' => 'Registro agregado exitosamenete.', 'template_id' => $request->template_id]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('admin/templates')->with(['type' => 'error', 'message' => 'Ocurrio un error.', 'template_id' => $request->template_id]);
        }
    }

    public function section_create(Request $request){
        DB::beginTransaction();
        try {
            Section::create([
                't_page_id' => $request->page_id,
                'name' => $request->name,
                'description' => $request->description
            ]);

            DB::commit();
            return redirect('admin/templates')->with(['type' => 'success', 'message' => 'Registro agregado exitosamenete.', 'template_id' => $request->template_id, 'page_id' => $request->page_id]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('admin/templates')->with(['type' => 'error', 'message' => 'Ocurrio un error.', 'template_id' => $request->template_id, 'page_id' => $request->page_id]);
        }
    }

    public function section_update(Request $request){
        DB::beginTransaction();
        try {
            $section = Section::find($request->id);
            $section->t_page_id = $request->page_id;
            $section->name = $request->name;
            $section->description = $request->description;
            $section->save();

            DB::commit();
            return redirect('admin/templates')->with(['type' => 'success', 'message' => 'Registro editado exitosamenete.', 'template_id' => $request->template_id, 'page_id' => $request->page_id]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('admin/templates')->with(['type' => 'error', 'message' => 'Ocurrio un error.', 'template_id' => $request->template_id, 'page_id' => $request->page_id]);
        }
    }

    public function section_delete($id, $template_id, $page_id){
        $section = Section::where('id', $id)->with(['blocks.inputs'])->first();
        DB::beginTransaction();
        try {
            foreach ($section->blocks as $block) {
                foreach ($block->inputs as $input) {
                    DB::table('t_block_input')->where('id', $input->id)->delete();
                }
                DB::table('t_blocks')->where('id', $block->id)->delete();
            }
            DB::table('t_sections')->where('id', $section->id)->delete();

            DB::commit();
            return redirect('admin/templates')->with(['type' => 'success', 'message' => 'Registro eliminado exitosamenete.', 'template_id' => $template_id, 'page_id' => $page_id]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('admin/templates')->with(['type' => 'error', 'message' => 'Ocurrio un error.', 'template_id' => $template_id, 'page_id' => $page_id]);
        }
    }

    public function create_block(Request $request){
        DB::beginTransaction();
        try {
            $block = Block::create([
                't_section_id' => $request->section_id
            ]);
            for ($i=0; $i < count($request->types); $i++) { 
                BlockInput::create([
                    't_block_id' => $block->id,
                    'name' => $request->name[$i],
                    'type' => $request->types[$i]
                ]);
            }
            DB::commit();
            return redirect('admin/templates')->with(['type' => 'success', 'message' => 'Registro agregado exitosamenete.', 'template_id' => $request->template_id, 'page_id' => $request->page_id]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('admin/templates')->with(['type' => 'error', 'message' => 'Ocurrio un error.', 'template_id' => $request->template_id, 'page_id' => $request->page_id]);
        }
    }

    public function options_block($type, $id, $template_id, $page_id){
        $block = Block::where('id', $id)->with(['inputs'])->first();
        DB::beginTransaction();
        try {
            switch ($type) {
                case 'duplicate':
                    $block_new = Block::create([
                        't_section_id' => $block->t_section_id
                    ]);
                    foreach ($block->inputs as $input) {
                        BlockInput::create([
                            't_block_id' => $block_new->id,
                            'name' => $input->name,
                            'type' => $input->type,
                            'value' => $input->value
                        ]);
                    }
                    DB::commit();
                    return redirect('admin/templates')->with(['type' => 'success', 'message' => 'Registro agregado exitosamenete.', 'template_id' => $template_id, 'page_id' => $page_id]);
                case 'delete':
                        $block = Block::find($id);
                        foreach ($block->inputs as $input) {
                            DB::table('t_block_input')->where('id', $input->id)->delete();
                        }
                        DB::table('t_blocks')->where('id', $block->id)->delete();
                        DB::commit();
                        return redirect('admin/templates')->with(['type' => 'success', 'message' => 'Registro eliminado exitosamenete.', 'template_id' => $template_id, 'page_id' => $page_id]);
                
                default:
                    # code...
                    break;
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('admin/templates')->with(['type' => 'error', 'message' => 'Ocurrio un error.', 'template_id' => $template_id, 'page_id' => $page_id]);
        }
    }

    public function update_block_input(Request $request){
        switch ($request->type) {
            case 'text':
                $input = BlockInput::find($request->id);
                $input->value = $request->value;
                $input->save();
                return response()->json(['id' => $request->id]);
            case 'long_text':
                $input = BlockInput::find($request->id);
                $input->value = $request->value;
                $input->save();
                return response()->json(['id' => $request->id]);
            case 'icon':
                $input = BlockInput::find($request->id);
                $input->value = $request->value;
                $input->save();
                return response()->json(['id' => $request->id]);
            case 'image':
                $image = $this->load_img($request->file('value-img'));
                if ($image) {
                    $input = BlockInput::find($request->id);
                    $input->value = $image;
                    $input->save();
                }
                return $image ? response()->json(['id' => $request->id, 'image' => $image]) : response()->json(['error' => 'Error al guardar la imagen']);
            default:
                # code...
                break;
        }
        return 1;
    }

    // ==============================================
    public function load_img($image){
        // dd($image);
        try {
            Storage::makeDirectory('/public/templates/images/'.date('F').date('Y'));
            $base_name = str_random(20);

            $filename = $base_name.'_small.'.$image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath())->orientate();
            $image_resize->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = 'templates/images/'.date('F').date('Y').'/'.$filename;
            $image_resize->save(public_path('../storage/app/public/'.$path));

            $filename = $base_name.'.'.$image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs(
                'public/templates/images/'.date('F').date('Y'),
                $image,
                $filename
            );

            return 'templates/images/'.date('F').date('Y').'/'.$filename;
        } catch (\Throwable $th) {
            return null;
        }
    }

    public static function section($id){
        $section = Section::where('id', $id)->with(['blocks.inputs'])->first();
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
}
