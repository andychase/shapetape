import os
import uuid

import boto3
from botocore.config import Config
from flask import render_template, request, redirect, jsonify, Flask

DEBUG = os.getenv('DEBUG', 'true') == 'true'
BUCKET = os.getenv('S3_BUCKET', 'shapetape')
app = Flask(__name__)


@app.route('/')
def index():
    return render_template('upload.html')


@app.route('/upload_request')
def upload_request():
    key = uuid.uuid4()
    s3 = boto3.client('s3', config=Config(signature_version='s3v4'))
    post_request = s3.generate_presigned_post(
        Bucket=BUCKET,
        Key='shapes/{}.svg'.format(key),
        Fields={
            'ContentType': 'image/svg+xml',
            'ACL': 'public-read'
        }
    )
    return jsonify(post_request)


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
