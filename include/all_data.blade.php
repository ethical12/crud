 @foreach($viewdata as $todo)
    <tr>
        
      <td>{{$no++}}</td>
      <td style="display: none;">{{$todo->id}}</td>
           <td>{{$todo->name}}</td>
           <td>{{$todo->number}}</td>
           <td>{{$todo->email}}</td>
           <td>{{$todo->role}}</td>
           <td><?php $status=$todo->status; if ($status == 1) { ?>
             <p style="color: green;">Active</p>
           <?php }else{ ?>
            <p style="color: red;">Not Active</p>
           <?php } ?></td>
           <td>{{$todo->created_at}}</td>
           <td>{{$todo->updated_at}}</td>
           <td><!-- <a href="#" class="delete">Delete</a> --><i class="fas fa-trash-alt delete"></i>
            <a href="{{route('todo_edit',[$todo->id])}}"><i class="fas fa-pen"></i></a>
            <a href="{{route('todo_view',[$todo->id])}}"><i class="far fa-eye view"></i></a>
           </td>
    </tr>
    @endforeach
    <script>  
$(".delete").click(function() {
    var $row = $(this).closest("tr");
    rowIndex =  $row.find('td:eq(1)').text();
      $('#delete_id').val(rowIndex);
    $('#delete_specialities_details').modal('show');   
});


</script> 
