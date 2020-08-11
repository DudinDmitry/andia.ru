@extends('admin')

@section('content')



    <div class="container col-md-12">

        <div class="row justify-content-center">

            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">Test
                        <div class="border col-md-2">

                            <form method="post" action="" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" class="form-control"><hr>
                                <input type="submit" name="submit" value="Отправить" class=" btn bg-olive form-control">
                            </form>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
