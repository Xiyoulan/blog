import Vue from 'vue'
import Message from './Message'
import FavoriteButton from './FavoriteButton';
import FollowButton from './FollowButton';

const components = {
    Message,
    FavoriteButton,
    FollowButton,
};

for (const [key, value] of Object.entries(components)) {
    Vue.component(key, value)
}