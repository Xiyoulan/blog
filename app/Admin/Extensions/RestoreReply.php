<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;

class RestoreReply
{

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

   $('.grid-row-restore').unbind('click').click(function() {

    var id = $(this).data('id');

    swal({
      title: "确认恢复?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "确认",
      closeOnConfirm: false,
      cancelButtonText: "取消"
    },
    function(){
        $.ajax({
            method: 'post',
            url: '/admin/replies/' + id+'/restore',
            data: {
                _token:LA.token,
            },
            success: function (data) {
                $.pjax.reload('#pjax-container');

                if (typeof data === 'object') {
                    if (data.status) {
                        swal(data.message, '', 'success');
                    } else {
                        swal(data.message, '', 'error');
                    }
                }
            }
        });
    });
});


SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a class='fa fa-reply grid-row-restore' data-id='{$this->id}' title='恢复'></a>";
    }

    public function __toString()
    {
        return $this->render();
    }

}
