function copyToClipboard(text) {
    // 创建一个临时的可编辑元素
    const textarea = document.createElement('textarea');
    // 将样式设置为隐藏，避免在页面上显示
    textarea.style.position = 'fixed';
    textarea.style.top = 0;
    textarea.style.left = 0;
    textarea.style.width = '2em';
    textarea.style.height = '2em';
    textarea.style.padding = 0;
    textarea.style.border = 'none';
    textarea.style.outline = 'none';
    textarea.style.boxShadow = 'none';
    textarea.style.background = 'transparent';
    // 将文本设置到创建的元素中
    textarea.value = text;
    // 将元素添加到文档中
    document.body.appendChild(textarea);
    // 选中文本
    textarea.select();
    // 执行复制操作
    const successful = document.execCommand('copy');
    // 从文档中移除元素
    document.body.removeChild(textarea);
    // 返回复制操作是否成功
    return successful;
}

// 使用示例
copyToClipboard('Hello, World!');

$(function () {

    //评论工具栏
    $("div[data-trigger-comment]").click(function () {
        const id = $(this).data('trigger-comment')
        const $target = $("form[data-comment-box='" + id + "']")
        const $commentBox = $("form[data-comment-box]")
        $commentBox.not($target).removeClass('flex').addClass('hidden');
        $commentBox.not($target).each(function () {
            if ($(this).is(":only-child")) {
                $(this).parent().removeClass('flex').addClass('hidden');
            }
        })
        if ($target.hasClass('flex')) {
            $target.removeClass('flex').addClass('hidden')
        } else {
            $target.removeClass('hidden').addClass('flex')
            $("div[data-comment-area='" + id + "']").removeClass('hidden').addClass('flex')
        }
    })


    // markdown解析
    $("div[data-content]").each(function (index) {
        new toastui.Editor({
            el: $(this).get(0),
            initialValue: $(this).data('content') + ''
        });
        $(this).attr('data-content', '')
    })

    // 互动工具栏
    $(document.body).on('click', function (event) {
        const $target = $(event.target); // 获取被点击的元素
        const $trigger = $($target.closest('[data-trigger]'))
        const $triggerItem = $($target.closest('[data-trigger-item]'))
        if ($trigger.length > 0) {
            $("div[data-trigger-item]").hide()
            $($trigger).next().toggle()
        } else if ($triggerItem.length > 0) {
            $($triggerItem).hide();
        } else {
            $("div[data-trigger-item]").hide()
        }
    })

    // 发起点赞
    $("form[data-like-form]").submit(function () {
        const id = $(this).data('like-form')
        const commentAreaSel = `div[data-comment-area='${id}']`
        $(this).ajaxSubmit(function (data) {
            $(commentAreaSel)
                .removeClass('hidden').addClass('flex')
            $(commentAreaSel).find("> div[data-fav-count-box]")
                .removeClass('hidden').addClass('flex')
            $(commentAreaSel).find(".fav_count").text(data.fav_count)
            $(commentAreaSel).find("span[data-like-persons]").text(data.like_persons)
        })
        return false;
    })


    setTimeout(() => {
        console.log('111111111111')
        $(".toastui-editor-contents pre code").each(function () {
            const $pre = $(this).parent()
            const copyBtn = $(`<button class="text-xs px-2 py-1 shadow top-2 right-2 absolute bg-white rounded hidden">复制</button>`)
            $pre.css("position", "relative")
            $pre.append(copyBtn).hover(()=>{
                copyBtn.text('复制').toggle()
            })
            copyBtn.bind('click',()=>{
                copyToClipboard($pre.find("code").text())
                copyBtn.text('已复制!')
            })


        })
    }, 1000)
})