@extends('layout.layout')
@section('xbody')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <div class="layui-row">
            {{--<form class="layui-form layui-col-md12 x-so">--}}
                {{--<input class="layui-input" placeholder="开始日" name="start" id="start">--}}
                {{--<input class="layui-input" placeholder="截止日" name="end" id="end">--}}
                {{--<input type="text" name="username" placeholder="请输入用户名" autocomplete="off" class="layui-input">--}}
                {{--<button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>--}}
            {{--</form>--}}
            <form class="layui-form layui-col-md12 x-so layui-form-pane" method="post" action="{{url('admin/roles/add')}}">
                {{csrf_field()}}
                <input class="layui-input" placeholder="角色名" name="role_name">
                <input class="layui-input" placeholder="角色描述" name="description">
                <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon"></i>增加</button>
                @include('errors')
            </form>
        </div>
        <xblock>
            {{--<button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>--}}
            <button class="layui-btn" >
                {{--<i class="layui-icon"></i>--}}
                角色列表
            </button>
            <span class="x-right" style="line-height:40px">共有数据：{{$roles->count()}} 条</span>
        </xblock>

        <table class="layui-table">
            <thead>
            <tr>
                <th>
                    <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i>
                    </div>
                </th>
                <th>ID</th>
                <th>角色名</th>
                <th>描述</th>
                <th>拥有权限规则</th>
                <th>权限管理</th>
                <th>操作</th>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>
                        <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i
                                    class="layui-icon">&#xe605;</i></div>
                    </td>
                    <td>{{$role->id}}</td>
                    <td>{{$role->role_name}}</td>
                    <td>{{$role->description}}</td>
                    <td>{{$role->permissions->implode('permission_name','-')}}</td>
                    <td class="td-status">
                        <span class="layui-btn layui-btn-normal layui-btn-mini"
                              onclick="x_admin_show('权限管理','{{url(config('admin.admin_uri')."/roles/{$role->id}/permission")}}')">权限管理</span>
                    </td>
                    <td class="td-manage">
                        {{--<a onclick="member_stop(this,'10001')" href="javascript:;" title="启用">--}}
                            {{--<i class="layui-icon">&#xe601;</i>--}}
                        {{--</a>--}}
                        {{--<a title="编辑" onclick="x_admin_show('编辑','role-add.html')" href="javascript:;">--}}
                            {{--<i class="layui-icon">&#xe642;</i>--}}
                        {{--</a>--}}
                        {{--<a title="删除" onclick="member_del(this,'要删除的id')" href="javascript:;">--}}
                            {{--<i class="layui-icon">&#xe640;</i>--}}
                        {{--</a>--}}
                        <a title="删除"  href="{{url(config('admin.admin_uri')."/roles/{$role->id}/delete")}}" onclick="if(confirm('确定删除吗?')==false)return false;">
                            <i class="layui-icon">&#xe640;</i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$roles->links()}}

    </div>
@endsection