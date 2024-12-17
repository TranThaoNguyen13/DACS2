<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('user', 'product')->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->reply = $request->input('reply'); // Admin trả lời
        $comment->save();

        return redirect()->route('admin.comments.index')->with('success', 'Cập nhật bình luận thành công!');
    }

    public function replyComment(Request $request, $commentId)
{
    $request->validate([
        'content' => 'required|string|max:255',
    ]);

    $comment = Comment::findOrFail($commentId);

    // Kiểm tra xem người dùng có phải là admin hay không
    if (auth()->user()->role !== 'admin') {
        return redirect()->back()->with('error', 'Bạn không có quyền trả lời bình luận.');
    }

    // Lưu câu trả lời
    $reply = new Comment();
    $reply->product_id = $comment->product_id;
    $reply->user_id = auth()->user()->id; // ID của admin
    $reply->content = $request->input('content');
    $reply->parent_id = $comment->id; // Liên kết câu trả lời với bình luận gốc
    $reply->save();

    return redirect()->back()->with('success', 'Trả lời bình luận thành công!');
}
// Trong CommentController hoặc controller tương ứng
public function reply(Request $request, $commentId)
{
    $comment = Comment::findOrFail($commentId);
    
    // Cập nhật câu trả lời của admin
    $comment->reply = $request->input('reply');
    $comment->save();

    return redirect()->back()->with('success', 'Đã trả lời bình luận.');
}
public function destroy($id)
    {
        // Tìm bình luận theo ID
        $comment = Comment::findOrFail($id);

        // Xóa bình luận
        $comment->delete();

        // Quay lại trang trước với thông báo thành công
        return redirect()->route('admin.comments.index')->with('success', 'Bình luận đã được xóa.');
    }

}
