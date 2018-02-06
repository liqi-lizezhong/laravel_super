<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Mail;
class StudentController extends Controller
{

//文件存储功能
    public  function upload(Request $request){
        if($request->isMethod('POST'))
        {
            //var_dump($_FILES);  原生php的方法。
            $file = $request->file('source');//使用laravel方法进行文件上传。
            //判断文件是否上传成功。
            if($file->isValid()) {
                //获取图片的原始名称
                $originname = $file->getClientOriginalName();
                //获取图片的扩展名称
                $ext = $file->getClientOriginalExtension();
                //获取图片的类型
                $type = $file->getClientMimeType();
                //获取图片的绝对路径
                $realpath = $file->getRealPath();

                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                $bool = Storage::disk('uploads')->put($filename, file_get_contents($realpath));
                var_dump($bool);
            }
            exit;
        }
        return View('student.upload');
    }
//邮箱功能
    public  function mail()
    {
        //1·发送纯文本
       /*Mail::raw('邮件内容 测试',function ($message){//第一个参数为邮件内容，第二个为功能
            $message->from('13141330125@163.com','慕课网');
            $message->subject('邮件主题 测试');//主题
            $message->to('582530680@qq.com');

        });*/
            //2·
           Mail::send('student.mail',['name'=>'sean'],function ($message){
                 $message->to('582530680@qq.com');
            });

    }
//缓存
    public  function cache1(){
       /* //put 保存对象到缓存中
        Cache::put('key1','value1',10);//第三个参数为有效期，此处为10分钟*/

       //2·add方法
        /*$bool = Cache::add('key2','value2',10);//若键值对存在，则不会成功，若不存在则成功。
        var_dump($bool);
    */
        //3·forever（） 永久保存
        //Cache::forever('key3','value3');
        //判断key是否存在。
        if(Cache::has('key4')){
            $val = Cache::get('key1');
            var_dump($val);
        }else{
            echo 'no';
        }


    }

    public  function cache2(){
        //1·get 从缓存中获取对象
        //$val = Cache::get('key3');

        //2·pull() 取出来之后然后删除。
        //$val = Cache::pull('key1');
        //3·forget() 从缓存中删除对象。
        $bool = Cache::forget('key2');
        var_dump($bool);

    }
//DEBUG模式测试
    public  function error(){
      //  $name = 'LZZ';
        //var_dump($name);
      /*  $student = null;
        if($student == null) {
                abort('404');//报错页面。HTTP错误框架提供的。
        }
        return View('student.error');*/
        //Log
          //Log::info('这是一个info级别的日志');
    // Log::warning('这是一条warning级别的日志');
        Log::error('这是一个数组',['name'=>'LZZ','age'=>18]);
    }
//推送迁移信息。
    public  function queue(){
        //将任务加入队列。
        dispatch(new SendEmail('582530680@qq.com'));
    }

}
