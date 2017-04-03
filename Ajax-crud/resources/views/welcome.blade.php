<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Laravel Ajax CRUD Example</title>

    <!-- Load Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-narrow">
        <h2>Laravel Ajax ToDo App</h2>
        <button id="btn-add" name="btn-add" class="btn btn-primary btn-xs">Add New Task</button>
        <div>
            
            <!-- Table-to-load-the-data Part -->
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Task</th>
                        <th>Description</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tasks-list" name="tasks-list">
                    @foreach ($tasks as $task)
                    <tr id="task{{ $task->id }}">
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->task }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->created_at }}</td>
                        <td>
                            <button class="btn btn-warning btn-xs btn-detail open-modal" value="{{ $task->id }}">Edit</button>
                            <button class="btn btn-danger btn-xs btn-delete delete-task" value="{{ $task->id }}">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal part -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                            <h4 class="modal-title" id=myModalLabel>Task Editor</h4>
                        </div>
                        <div class="modal-body">

                            <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">
                               
                               <div class="form-group error">
                                   <label for="inputTask" class="col-sm-3 control-label">Tasks</label>
                                   <div class col="col-sm-9">
                                       <input type="text" class="form-control has-error" id="task" name="task" value="nergfsd">
                                   </div> 
                               </div>

                               <div class="form-group">
                                   <label for="inputEmail3" class="col-sm-3 control-label">Description</label>
                                   <div class col="col-sm-9">
                                       <input type="text" class="form-control" id="description" name="description" value="fstest">
                                   </div> 
                               </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
                            <input type="hidden" id="task_id" name="task_id" value="0">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <meta name="_token" content="{{ csrf_token() }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="{{asset('js/ajax-crud.js')}}"></script>
</body>
</html>