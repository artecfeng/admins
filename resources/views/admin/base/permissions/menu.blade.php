@extends('layout.layout')
@section('xbody')
    <div class="x-body">
        <form action="" method="post" class="layui-form layui-form-pane">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>权限名
                </label>
                <label for="name" class="layui-form-label">
                    {{$permission->permission_name}}
                </label>
                <label for="name" class="layui-form-label" style="margin-left: 2em">
                    <span class="x-red">*</span>描述
                </label>
                <label for="name" class="layui-form-label">
                    {{-- todo::添加用户描述--}}
                    {{$permission->description}}
                </label>

            </div>

            {{--@if($myRoles->contains($role))--}}
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    拥有菜单
                </label>
                <table class="layui-table layui-input-block">
                    <tbody>
                    @foreach($myMenus as $menu)
                        <tr>
                            <td>
                                <input type="checkbox" name="menus[]" checked value="{{$menu->id}}"
                                       lay-skin="primary" title="{{$menu->menu_name}}">
                            </td>
                            <td>
                                <div class="layui-input-block">
                                    <input name="id[]" lay-skin="primary" type="checkbox" title="用户停用" value="2">

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label x-red">
                    未拥有菜单
                </label>
                <table class="layui-table layui-input-block">
                    <tbody>
                    @foreach($menus as $menu)
                        @if(!$myMenus->contains($menu))
                            <tr>
                                <td>
                                    <input type="checkbox" name="menus[]" value="{{$menu->id}}"
                                           lay-skin="primary"
                                           title="{{$menu->menu_name}}">
                                </td>
                                <td>
                                    <div class="layui-input-block">
                                        <input name="id[]" lay-skin="primary" type="checkbox" title="用户停用" value="2">

                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="layui-form-item layui-form-text">
                <label for="desc" class="layui-form-label">
                    描述
                </label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" id="desc" name="desc" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                @include('errors')
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">提交</button>
            </div>
        </form>
    </div>
@endsection