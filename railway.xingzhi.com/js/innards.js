//var imgDomain = "http://192.168.1.111:7004/myphoto";
//var urlJson = "http://192.168.1.111:8000/MyPhotoApi/randomphotoList";
// Slideshow Images
var array = [
    { image: '', title: 'image', thumb: '' },
    { image: '', title: 'image', thumb: '' },
    { image: '', title: 'Image', thumb: '' },
    { image: '', title: 'Image', thumb: '' },
    { image: '', title: 'Image', thumb: '' },
    { image: '', title: 'image', thumb: '' },
    { image: '', title: 'Image', thumb: '' },
    { image: '', title: 'Image', thumb: '' },
    { image: '', title: 'Image', thumb: '' },
];

$.ajax(urlJson, {
    data: { row: 9 },
    async: false,
    dataType: "jsonp",
    jsonp: "callback",
    crossDomain: true,
    success: function (json) {
        $.each(json, function (i, k) {
            array[i].image = imgDomain + k.Original;
            array[i].thumb = imgDomain + k.Thumbnail;
            array[i].title = "";
        });
        $.supersized({
            // 功能
            slideshow: 1,			// 幻灯显示 1.开 / 0.关
            autoplay: 1,			// 加载页面后自动幻灯显示. (1.表示自动开始幻灯显示.0.表示不幻灯)
            start_slide: 1,			// 页面加载后是否随机一张图片开始显示. (0 表示随机获取一张开始)
            stop_loop: 0,			// 换等到最后一张是否继续循环显示.0.表示循环.1.表示不循环.
            random: 0,			    // 随机排序幻灯 (不管是否已开始)
            slide_interval: 2000,	// 每一张图片之间的过渡时间.
            transition: 6, 			// 图片变幻时的效果. 0-不设置, 1-逐渐消逝, 2-从上到下, 3-从右到左, 4-从下到上, 5-从左到右, 6-从右推向左, 7-从左推向右
            transition_speed: 1200,	// 图片之间过渡变化时的效果
            new_window: 0,			// 图片链接在新的窗口或标签内打开
            pause_hover: 0,			// 鼠标悬浮在图片下方时，暂停幻灯.
            keyboard_nav: 1,        // 是否开启键盘左右按键移动图片.1.表示开启.0.表示不开启
            performance: 2,			// 执行：0-正常, 1-混合质量, 2-最优的图片质量, 3-最优的图片过度 // (仅支持 Firefox/IE, 不支持 Webkit)
            image_protect: 0,
            slide_captions:1,      //是否显示图片标题。
            // 大小尺寸 & 位置
            min_width: 0,			// 允许的最小宽度 (pixels)
            min_height: 0,			// 允许的最小高度 (pixels)
            vertical_center: 1,     // 中心垂直背景平铺
            horizontal_center: 0,   // 中心水平背景平铺
            fit_always: 0,			// Image will never exceed browser width or height (Ignores min. dimensions)
            fit_portrait: 1,		// Portrait images will not exceed browser height
            fit_landscape: 0,		// Landscape images will not exceed browser width
            // 部分
            slide_links: 'name',	// Individual links for each slide (Options: false, 'number', 'name', 'blank')
            thumb_links: 1,			    // 启用每张大图对应显示小缩略图.0.表示不启用.1.表示启用.
            thumbnail_navigation: 0,    // 是否开启缩略图导航.0.关闭.1.开启
            slides: array,          //幻灯图片数组.
            // Theme Options
            progress_bar: 1,			// Timer for each slide
            mouse_scrub: 0
        });
    },
    error: function (e) {
        alert('Error...');
    }
});