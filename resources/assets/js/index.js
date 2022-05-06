Dcat.ready(function () {
    let navbar_items = $('ul.nav-sidebar').children('li.nav-item');
    // 移除系统自动添加的菜单
    navbar_items.each(function () {
        $(this).remove()
    })
    // 移除系统默认头部
    $('div.navbar-header').remove()
    $('.sidebar').removeClass('ps ps--active-y')
    active_menu()

    // 父菜单选中操作
    $(".side-nav-link").click(function () {
        let $this = $(this), id = $this.attr('data-id'), treeview = $(".has-treeview");
        $(".side-nav-link").removeClass('side-nav-active active')
        $(".sub-link").removeClass('sub-active active')
        treeview.removeClass('menu-open')
        treeview.children('ul').css('display', 'none')
        $this.addClass('side-nav-active')
        let href = $this.attr('href');
        $(".sub-menu-item").css('display', 'none')
        let subMenu = $(".sub-menu-item[data-sub-id='" + id + "']");
        subMenu.css('display', 'block')
        subMenu.find('a.sub-link').each(function () {
            let $that = $(this)
            let subParent = $that.parents().eq(2)
            let active = JSON.parse(localStorage.getItem('menuActive'))
            if (active != null && (active.subID === $that.attr('data-id') || href !== 'javascript:void(0);')) {
                if (subParent.hasClass('has-treeview')) {
                    subParent.addClass('menu-open')
                    subParent.children('ul').css('display', 'block')
                }
                $that.addClass('sub-active')
                let menuActive = {parentID: id, subID: $that.attr('data-id')};
                localStorage.setItem('menuActive', JSON.stringify(menuActive))
            }
        })
    })

    // 子菜单选中操作
    $(".sub-link").click(function () {
        let $this = $(this);
        let id = 0, parents = $this.parents();
        if ($this.parents().eq(3).hasClass('sub-menu-item')) {
            id = parents.eq(3).attr('data-sub-id')
        } else {
            id = parents.eq(1).attr('data-sub-id')
        }
        if (!$this.parent().hasClass('has-treeview')) {
            $(".sub-link").removeClass('sub-active active')
            $this.addClass('sub-active')
            let subParent = parents.eq(2)
            if (subParent.hasClass('has-treeview')) {
                subParent.addClass('menu-open')
            }
            subParent.parent().find('.has-treeview').each(function () {
                let $that = $(this);
                if (subParent.attr('data-tree-id') !== $that.attr('data-tree-id')) {
                    $that.removeClass('menu-open')
                    $that.children('ul').css('display', 'none')
                }
            })
        }
        let menuActive = {parentID: id, subID: $this.attr('data-id')};
        localStorage.setItem('menuActive', JSON.stringify(menuActive))
    })

    // 页面刷新操作后自动选中刷新之前的菜单
    function active_menu() {
        let parentIsActive = false;
        $('.side-scroll').find('li.side-nav-item').each(function () {
            if ($(this).children('a').hasClass('side-nav-active')) {
                parentIsActive = true
            }
        })
        let menuActive;
        if (!parentIsActive) {
            menuActive = JSON.parse(localStorage.getItem('menuActive'))
        }else{
            menuActive = JSON.parse(localStorage.getItem('menuActive'));
            if (!menuActive){
                menuActive = {"parentID":"1","subID":"1"}
                localStorage.setItem('menuActive', JSON.stringify(menuActive))
            }
        }
        $(".side-nav-link").removeClass('side-nav-active');
        $('.sub-menu-item').hide();
        $(".sub-link").removeClass('sub-active');
        $(".side-nav-link[data-id='" + menuActive.parentID + "']").addClass('side-nav-active');
        let subMenu = $(".sub-menu-item[data-sub-id='" + menuActive.parentID + "']")
        subMenu.css('display', 'block')
        subMenu.find('a').each(function () {
            let $that = $(this)
            if (menuActive.subID === $that.attr('data-id')) {
                let subParent = $that.parents().eq(2)
                if (subParent.hasClass('has-treeview')) {
                    subParent.addClass('menu-open')
                }
                $that.addClass('sub-active')
            }
        })
    }
})
