import os

import boto3
from flask import render_template, request, redirect, current_app, jsonify

from settings import app, redis


@app.route('/')
def index():
    return render_template('upload.html')


@app.route('/upload_request')
def upload_request():
    key = redis.incr('shape_tape_id_index')
    s3 = boto3.resource('s3')
    post_request = s3.generate_presigned_post(
        current_app.config['bucket'],
        'shapes/{}.svg'.format(key),
        {
            'ContentType': 'image/svg+xml',
            'ACL': 'public-read'
        }
    )
    return jsonify({
        'request': post_request['url'],
        'url': '{}.svg'.format(key)
    })


@app.route('/<int:vector>')
def viewer(vector):
    return render_template('viewer.html', v=int(vector))


@app.route('/<int:vector>.svg')
def view_svg(vector):
    if 'gzip' in request.headers.get('HTTP_ACCEPT_ENCODING'):
        return redirect('http://s.shapetape.xyz/{}.svg.gz'.format(vector), 303)
    else:
        return redirect('http://s.shapetape.xyz/{}.svg'.format(vector), 303)


if __name__ == '__main__':
    if os.environ.get('DEBUG', '') == 'true':
        app.run(debug=True)
