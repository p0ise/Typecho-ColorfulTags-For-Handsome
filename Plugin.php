<?php
/**
 * <a href='https://blog.irow.top/archives/396.html' title='项目主页' target='_blank'>彩色3D标签云插件</a>
 *
 * @package ColorfulTags
 * @author 锋临
 * @version 1.6
 * @link https://www.invelop.cn/
 */
class ColorfulTags_Plugin implements Typecho_Plugin_Interface {
	/* 激活插件方法 */
	public static function activate() {
		Typecho_Plugin::factory('Widget_Archive')->footer = array(__CLASS__, 'render');
	}
	/* 禁用插件方法 */
	public static function deactivate() {
	}
	/* 插件配置方法 */
	public static function config(Typecho_Widget_Helper_Form $form) {
		$is_3d = new Typecho_Widget_Helper_Form_Element_Radio('is_3d', ['0' => _t('否'), '1' => _t('是')], '0', _t('是否启用3D效果'), _t('开启后标签云会围绕3D球体滚动'));
		$form->addInput($is_3d);
		$radius = new Typecho_Widget_Helper_Form_Element_Text(
					'radius', NULL, '80',
					_t('3D标签云半径：'),
					_t('默认为80，如果不是很清楚请勿修改')
				);
		$form->addInput($radius);
		$speed = new Typecho_Widget_Helper_Form_Element_Text(
					'speed', NULL, '11',
					_t('3D旋转速度：'),
					_t('默认为11，如果不是很清楚请勿修改')
				);
		$form->addInput($speed);
		$is_pjax = new Typecho_Widget_Helper_Form_Element_Radio('is_pjax', ['0' => _t('否'), '1' => _t('是')], '0', _t('是否启用了PJAX'), _t('如果你启用了pjax,当切换页面时候，js不会重写绑定事件到新生成的节点上。
			你可以在该项设置中重新加载js函数，以便将事件正确绑定ajax生成的DOM节点上'));
		$form->addInput($is_pjax);
	}
	/* 个人用户的配置方法 */
	public static function personalConfig(Typecho_Widget_Helper_Form $form) {
	}
	/* 插件实现方法 */
	public static function render($archive) {
		/*获取参数*/
		$options = Helper::options();
		$is_3d = $options->plugin('ColorfulTags')->is_3d;
		$radius = $options->plugin('ColorfulTags')->radius;
		$speed = $options->plugin('ColorfulTags')->speed;
		$is_pjax = $options->plugin('ColorfulTags')->is_pjax;
		$is_post = $archive->parameter->type=='post';
		$static_src = $options->pluginUrl.'/ColorfulTags/static';
		
		if($is_pjax) {
			if($is_post||!$is_3d){
				$html = <<<html
							<!-- Start ColorfulTags -->
							<link rel="stylesheet" type="text/css" href="{$static_src}/css/colorfultags.min.css">
							<script src="{$static_src}/js/colorfultags.min.js"></script>
							<script id="colorfultags">
							console.info("%c彩色标签云-锋临|BLOG.IROW.TOP","line-height:28px;padding:4px;background:#3f51b5;color:#fff;font-size:14px;font-family:Microsoft YaHei;");
							colorfultags("#tag_cloud-2 > div > a");
							$($(document).on("pjax:complete", function() {
								colorfultags("#tag_cloud-2 > div > a")
							}));
							</script>
							<!-- End ColorfulTags -->
html;
			} else{
				$html = <<<html
							<!-- Start ColorfulTags -->
							<link rel="stylesheet" type="text/css" href="{$static_src}/css/colorfultags.min.css">
							<link rel="stylesheet" type="text/css" href="{$static_src}/css/around3d.min.css">
							<script src="{$static_src}/js/colorfultags.min.js"></script>
							<script src="{$static_src}/js/around3d.min.js"></script>
							<script id="#colorfultags">
							console.info("%c彩色标签云-锋临|BLOG.IROW.TOP","line-height:28px;padding:4px;background:#3f51b5;color:#fff;font-size:14px;font-family:Microsoft YaHei;");
							colorfultags("#tag_cloud-2 > div > a");
							around3D("#tag_cloud-2>div",{$radius}, 200, Math.PI / 180, 1, 1, true, {$speed}, 200, 0, 10, 1);
							$($(document).on("pjax:complete", function() {
                                colorfultags("#tag_cloud-2 > div > a");
								around3D("#tag_cloud-2>div",{$radius}, 200, Math.PI / 180, 1, 1, true, {$speed}, 200, 0, 10, 1)
							}));
							</script>
							<!-- End ColorfulTags -->
html;
			}
		} else{
			if($is_post||!$is_3d){
				$html = <<<html
							<!-- Start ColorfulTags -->
							<link rel="stylesheet" type="text/css" href="{$static_src}/css/colorfultags.min.css">
							<script src="{$static_src}/js/colorfultags.min.js"></script>
							<script>
							console.info("%c彩色标签云-锋临|BLOG.IROW.TOP","line-height:28px;padding:4px;background:#3f51b5;color:#fff;font-size:14px;font-family:Microsoft YaHei;");
							colorfultags("#tag_cloud-2 > div > a");
							</script>
							<!-- End ColorfulTags -->
html;
			} else{
				$html = <<<html
							<!-- Start ColorfulTags -->
							<link rel="stylesheet" type="text/css" href="{$static_src}/css/colorfultags.min.css">
							<link rel="stylesheet" type="text/css" href="{$static_src}/css/around3d.min.css">
							<script src="{$static_src}/js/colorfultags.min.js"></script>
							<script src="{$static_src}/js/around3d.min.js"></script>
							<script>
							console.info("%c彩色标签云-锋临|BLOG.IROW.TOP","line-height:28px;padding:4px;background:#3f51b5;color:#fff;font-size:14px;font-family:Microsoft YaHei;");
							colorfultags("#tag_cloud-2 > div > a");
							around3D("#tag_cloud-2>div",{$radius}, 200, Math.PI / 180, 1, 1, true, {$speed}, 200, 0, 10, 1);
							</script>
							<!-- End ColorfulTags -->
html;
			}
		}
		echo $html;
	}
}