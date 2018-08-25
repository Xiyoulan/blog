import Vue from 'vue';
import title from './title';
const directives = {
    title,
};

for (const [key, value] of Object.entries(directives)) {
    Vue.directive(key, value)
}