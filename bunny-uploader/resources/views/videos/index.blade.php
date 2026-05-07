<x-layout>
    <script src="https://cdn.jsdelivr.net/npm/tus-js-client@latest/dist/tus.min.js"></script>

    <form method="POST" id="videosForm">
        @csrf
        <input type="file" multiple name="videos[]" id="videos">
        <button type="submit" id="submitForm">Enviar videos</button>
    </form>
    <script>
        const form = document.getElementById("videosForm");
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const files = document.getElementById("videos").files;
            for (const file of files) {
                const newVideo = {
                    name: file.name,
                    collectionId: @json(session('active_collection')),
                };
                const response = await fetch('{{ route('videos.authorize') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify(newVideo)
                });
                const credentials = await response.json();
                console.log('credentials recebidas:', credentials);

                const upload = new tus.Upload(file, {
                    endpoint: "https://video.bunnycdn.com/tusupload",
                    retryDelays: [0, 3000, 5000, 10000, 20000, 60000, 60000],
                    headers: {
                        AuthorizationSignature: credentials.signature,
                        AuthorizationExpire: credentials.expirationTime,
                        VideoId: credentials.videoId,
                        LibraryId: credentials.libraryId,
                    },
                    metadata: {
                        filetype: file.type,
                        title: file.name,
                    },
                    onError: function(error) {
                        console.error("Upload failed:", error);
                    },
                    onProgress: function(bytesUploaded, bytesTotal) {
                        const percentage = ((bytesUploaded / bytesTotal) * 100).toFixed(2);
                        Livewire.dispatch('update-progress', {
                            filename: file.name,
                            percentage: parseFloat(percentage)
                        })
                    },
                    onSuccess: function() {
                        console.log("Upload complete!");
                    }
                });
                upload.findPreviousUploads().then(function(previousUploads) {
                    if (previousUploads.length) {
                        upload.resumeFromPreviousUpload(previousUploads[0]);
                    }
                    upload.start();
                });

            }
        });
    </script>
    <livewire:video-upload-status />
    @foreach ($videos as $video)
        <form method="POST" action="{{ route('videos.update', $video) }}">
            @method('PUT')
            @csrf
            <input type="text" name="name" id="name" value="{{ $video->name }}">
            <button type="submit">Salvar</button>
        </form>
    @endforeach
</x-layout>
