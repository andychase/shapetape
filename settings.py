import os

from flask import Flask
from flask.ext.assets import Environment, Bundle
from flask.ext.redis import FlaskRedis
from redis import StrictRedis

app = Flask(__name__)


class FlaskConfig(object):
    DEBUG = os.getenv('DEBUG', 'true') == 'true'
    REDIS_URL = os.getenv('REDIS_URL', '')
    BUCKET = os.getenv('S3_BUCKET')


app.config.from_object(FlaskConfig)


class DecodedRedis(StrictRedis):
    @classmethod
    def from_url(cls, url, db=None, **kwargs):
        kwargs['decode_responses'] = True
        return StrictRedis.from_url(url, db, **kwargs)


redis = FlaskRedis.from_custom_provider(DecodedRedis, app)
redis.decode_responses = True

assets = Environment(app)

css = Bundle(
    'css/normalize.scss',
    'css/style.scss',
    filters=["libsass", "cssmin"],
    output='output/css.%(version)s.css'
)
js = Bundle(
    'js/script.js',
    'js/viewer.js',
    output='output/js_all.%(version)s.js'
)

assets.register('css_all', css)
assets.register('js_all', js)
