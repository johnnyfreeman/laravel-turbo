# Hotwire Turbo for Laravel

Some lightweight tools for sending Turbo Streams to the front end.

## Installation

You can install the package via composer:

```bash
composer require johnnyfreeman/laravel-turbo
```

## Usage

Controler

```php
class PostCommentController
{
    public function store(Request $request, Post $post)
    {
        $comment = $post->comments()->create([
            'text' => $request->get('text')
        ]);

        if ($request->wantsTurboStream()) {
            return turbo_stream()
                ->prepend('comments', 'posts.comment', [
                    'text' => $comment->text
                ])
                ->append('notifications', 'notifications.simple', [
                    'title' => 'Post comment created!'
                ]);
        }

        return back();
    }
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
