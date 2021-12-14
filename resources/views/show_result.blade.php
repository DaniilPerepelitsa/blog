<body>

<main role="main">

    <div class="album py-5 bg-light">
        <div class="container">


            <div class="row" style="width: 50%; padding-left: 25%; padding-top: 50px">
                @forelse($posts as $post)
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <div class="card-header">
                                <h3>{{$post->id}}. {{$post->title}}</h3>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{$post->content}}</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                @empty
                    Nothing found
                @endforelse
            </div>
        </div>
    </div>

</main>


<script src="{{ mix('js/app.js') }}"></script>
</body>
