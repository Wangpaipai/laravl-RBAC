<?php

//未登录中间件
Route::group(['middleware' => ['notLogin']], function () {
	Route::get('/login','LoginController@index')->name('admin.login.index');//登录页面
	Route::post('/login','LoginController@login')->name('admin.login.login');//登录
});

//登录中间件
Route::group(['middleware' => ['login']], function () {

	Route::get('/main', 'IndexController@main')->name('admin.index.main');//数据统计页

	Route::get('/loginout','LoginController@loginOut')->name('admin.login.out');//退出登录

	Route::match(['get', 'post'],'/data/update','AdminController@dataUpdate')->name('admin.data.update');//修改个人资料

	//菜单列表中间件
	Route::group(['middleware' => ['menu']], function () {
		Route::get('/','IndexController@index')->name('admin.index.index');//首页
	});

	//权限中间件  设计权限操作都写在这里面
	Route::group(['middleware' => ['Jurisdiction']], function () {
		Route::prefix('admin')->group(function () {
			Route::get('/', 'AdminController@index')->name('admin.admin.index');//管理员列表
			Route::match(['get', 'post'],'/create', 'AdminController@createAdmin')->name('admin.admin.create');//新增管理员
			Route::match(['get', 'post'],'/update', 'AdminController@updateAdmin')->name('admin.admin.update');//修改管理员信息
			Route::get('/delete', 'AdminController@delUser')->name('admin.admin.delete');//删除管理员
			Route::get('/setStatus', 'AdminController@setStatus')->name('admin.admin.setStatus');//设置管理员状态
		});

		Route::prefix('menu')->group(function () {
			Route::get('/', 'MenuController@index')->name('admin.menu.index');//菜单列表
			Route::match(['get', 'post'],'/create', 'MenuController@createMenu')->name('admin.menu.create');//新增菜单
			Route::match(['get', 'post'],'/update', 'MenuController@updateMenu')->name('admin.menu.update');//修改菜单
			Route::get('/setStatus', 'MenuController@setStatus')->name('admin.menu.setStatus');//设置菜单状态
			Route::post('/setSort', 'MenuController@setSort')->name('admin.menu.setSort');//更新排序
		});

		Route::prefix('node')->group(function () {
			Route::get('/', 'NodeController@index')->name('admin.node.index');//节点列表
			Route::match(['get', 'post'],'/create', 'NodeController@createNode')->name('admin.node.create');//新增节点
			Route::match(['get', 'post'],'/update', 'NodeController@updateNode')->name('admin.node.update');//修改节点
			Route::get('/setStatus', 'NodeController@setStatus')->name('admin.node.setStatus');//设置节点状态
			Route::post('/setSort', 'NodeController@setSort')->name('admin.node.setSort');//更新排序
		});

		Route::prefix('role')->group(function () {
			Route::get('/', 'RoleController@index')->name('admin.role.index');//角色列表
			Route::match(['get', 'post'],'/create', 'RoleController@createRole')->name('admin.role.create');//新增角色
			Route::match(['get', 'post'],'/update', 'RoleController@updateRole')->name('admin.role.update');//修改角色
			Route::get('/setStatus', 'RoleController@setStatus')->name('admin.role.setStatus');//设置角色状态
			Route::post('/setSort', 'RoleController@setSort')->name('admin.role.setSort');//更新排序
			Route::match(['get', 'post'],'/power', 'RoleController@power')->name('admin.role.power');//分配权限
		});
	});
});



