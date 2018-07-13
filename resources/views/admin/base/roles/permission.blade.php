@extends('layout.layout')
@section('xbody')
    <div class="x-body">
        <form action="" method="post" class="layui-form layui-form-pane">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>角色名
                </label>
                <label for="name" class="layui-form-label">
                    {{$role->role_name}}
                </label>
                <label for="name" class="layui-form-label" style="margin-left: 2em">
                    <span class="x-red">*</span>描述
                </label>
                <label for="name" class="layui-form-label">
                    {{-- todo::添加用户描述--}}
                    {{$role->description}}
                </label>

            </div>

            {{--@if($myRoles->contains($role))--}}
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    拥有权限
                </label>
                <table class="layui-table layui-input-block">
                    <tbody>
                    @foreach($myPermissions as $permission)
                        <tr>
                            <td>
                                <input type="checkbox" name="permissions[]" checked value="{{$permission->id}}"
                                       lay-skin="primary" title="{{$permission->permission_name}}">
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
                    未拥有权限
                </label>
                <table class="layui-table layui-input-block">
                    <tbody>
                    @foreach($permissions as $permission)
                        @if(!$myPermissions->contains($permission))
                            <tr>
                                <td>
                                    <input type="checkbox" name="permissions[]" value="{{$permission->id}}" lay-skin="primary"
                                           title="{{$permission->permission_name}}">
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