<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\ReplyRequest;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['showChildReplies']]);
    }

    public function showChildReplies(Reply $reply)
    {
        $childReplies = $reply->childReplies;
        return response()->json($childReplies);
    }

    public function store(ReplyRequest $request, Reply $reply)
    {

        $reply->content = $request->content;
        $reply->article_id = $request->article_id;
        $reply->parent_id = $request->parent_id ?: 0;
        $reply->to = $request->reply_to_id ?: null;
        $reply->from = \Auth::id();
        $reply->save();
        //dd($reply->toArray());
        if($request->ajax()){
          return response()->json($reply, 201);
        }
         return redirect(url()->previous().'#reply'.$reply->id)->with('success','发布成功');
    }

    public function destroy(Reply $reply){
        $this->authorize('destroy',$reply);
        $reply->delete();
        return back()->with('info','成功删除回复!');
    }
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success' => false,
            'msg' => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        $file = $request->upload_file;
        if ($file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'replies', \Auth::id(), 500);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg'] = "上传成功!";
                $data['success'] = true;
            }
        }
        return $data;
    }

}
