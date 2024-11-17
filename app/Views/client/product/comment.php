<div class="card p-md-5 p-4 border-0 bg-secondary">
    <div class="card-body w-100 mx-auto px-0" style="max-width: 746px;">
        <h2 class="mb-4 pb-3">Để lại bình luận</h2>

        <form id="commentForm" class="row gy-4" wire:submit.prevent="sendComment">
            <div class="col-sm-6 col-12">
                <label for="fn" class="form-label fs-base">Họ tên</label>
                <input wire:model="comment_name" placeholder="Họ tên" type="text"
                    class="form-control form-control-lg " id="fn" required="">
            </div>
            <div class="col-sm-6 col-12">
                <label for="comment_email" class="form-label fs-base">Email</label>
                <input wire:model="comment_email" placeholder="Email" type="email"
                    class="form-control form-control-lg " id="comment_email">
            </div>
            <div class="col-12">
                <label for="comment_text" class="form-label fs-base">Bình luận</label>
                <textarea wire:model="comment_text" placeholder="Nội dung bình luận..." class="form-control form-control-lg "
                    id="comment_text" rows="3" required=""></textarea>
            </div>


            <div class="col-12">
                <button type="submit" class="btn btn-lg btn-primary w-sm-auto w-100 mt-2">Gửi bình luận</button>
            </div>
        </form>
    </div>
</div>