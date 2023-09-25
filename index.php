<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">

    <title>Php Ajex Crud</title>
</head>

<body>
    <div class="container">
        <h1 class="text-primary text-uppercase text-center"> AJAX CRUD
            OPERATION </h1>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Add Data
            </button>
        </div>
        <h2 class="text-danger">All Records </h2>

        <!-- The Modal -->
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Firstname:</label>
                            <input type="text" name="" id="fname" class="form-control" placeholder="First Name">
                        </div>

                        <div class="form-group">
                            <label>Lastname</label>
                            <input type="text" name="" id="lname" class="form-control" placeholder="Last Name">
                        </div>

                        <div class="form-group">
                            <label>Class</label>
                            <input type="text" name="" id="classs" class="form-control" placeholder="Class">
                        </div>

                        <div class="form-group">
                            <label>Grade:</label>
                            <input type="text" name="" id="grade" class="form-control" placeholder="Grade">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="sumbit" data-dismiss="modal">Add</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            <!-- update -->

        </div>

    </div>
    <div class="modal fade" id="Update_myModal" tabindex="-1" role="dialog" aria-labelledby="myModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Firstname:</label>
                        <input type="text" name="" id="update_fname" class="form-control" placeholder="First Name">
                    </div>

                    <div class="form-group">
                        <label>Lastname</label>
                        <input type="text" name="" id="update_lname" class="form-control" placeholder="Last Name">
                    </div>

                    <div class="form-group">
                        <label>Class</label>
                        <input type="text" name="" id="update_class" class="form-control" placeholder="Class">
                    </div>

                    <div class="form-group">
                        <label>Grade:</label>
                        <input type="text" name="" id="update_grade" class="form-control" placeholder="Grade">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="update" data-dismiss="modal">update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="hidden" id="hidden_user_id">

                </div>
            </div>
        </div>
    </div>

    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header">
                    <h1>Php Ajex crud</h1>
                    <div class="" id="studentdata">
                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

    <script>
        var currentPage = 1; // Initialize the current page to 1

    function readrecord(page) {
        var read = "read";
        $.ajax({
            type: "post",
            url: "fetch.php",
            data: {
                read: read,
                page: page
            },
            success: function(response, status) {
              
                $('#studentdata').html(response);
                currentPage = page;
            }
        });
    }

    ///    pagination       

    $(document).on("click", "#pagination a", function(e) {
        e.preventDefault();
        var page_id = $(this).attr("id");
        readrecord(page_id);
    });
    $(document).on('click', '#sumbit', function(e) {
        e.preventDefault();
        var fname = $('#fname').val();
        var lname = $('#lname').val();
        var classs = $('#classs').val();
        var grade = $('#grade').val();
        $.ajax({
            type: "post",
            url: "fetch.php",
            data: {
                fname: fname,
                lname: lname,
                class: classs,
                grade: grade
            },
            success: function(response, status) {
                $('#fname').val('');
                $('#lname').val('');
                $('#classs').val('');
                $('#grade').val('');

                readrecord(currentPage);
            }
        });
    });

    $(document).ready(function() {
        readrecord();
    });

    function DeleteUser(deleteid) {
        var conf = confirm("Are you sure yo want to delelt")
        if (conf == true) {
            $.ajax({
                type: "post",
                url: "fetch.php",
                data: {
                    deleteid: deleteid
                },
                success: function(response, ) {
                    readrecord(currentPage );
                }
            });
        }
    }
    // $(document).on('click', '#sumbit', function(e) {
    //     e.preventDefault();
    // });

    function Updateuser(id) {
        $('#hidden_user_id').val(id);

        $.post("fetch.php", {
            id: id
        }, function(data, textStatus) {
            var user = JSON.parse(data);
            // alert(user.fname);

            $('#update_fname').val(user.fname);
            $('#update_lname').val(user.lname);
            $('#update_class').val(user.class);
            $('#update_grade').val(user.grade);
        });

        $('#Update_myModal').modal("show"); // 
    }

    $(document).on('click', '#update', function(e) {
        e.preventDefault();
        var fnameup = $('#update_fname').val();
        var lnameup = $('#update_lname').val();
        var Updateclassup = $('#update_class').val();
        var gradeup = $('#update_grade').val();
        var hidden_user_idup = $('#hidden_user_id').val();

        $.post("fetch.php", {
                fnameup: fnameup,
                hidden_user_idup: hidden_user_idup,
                lnameup: lnameup,
                gradeup: gradeup,
                classup: Updateclassup,
            },
            function(data, textStatus) {
                $('#Update_myModal').modal("hide");
                readrecord(currentPage);
            },
        );
    });
    </script>
</body>

</html>