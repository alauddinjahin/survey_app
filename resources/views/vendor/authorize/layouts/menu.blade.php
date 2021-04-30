<div class="col-md-4">
    <div class="panel panel-default">
        <div class="list-group">
            <a href="{{ url('/' . Config("authorization.route-prefix") . '/users') }}"
               class="list-group-item">Users</a>
            <a href="{{ url('/' . Config("authorization.route-prefix") . '/roles') }}"
               class="list-group-item">Role</a>
            <a href="{{ url('/' . Config("authorization.route-prefix") . '/permissions') }}"
               class="list-group-item">Permission</a>
        </div>
    </div>
</div>