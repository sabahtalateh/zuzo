<template>
    <div class="wrapper">
        <div>
            <PostForm @postCreated="addPost" :editingPost="editingPost"/>
        </div>
        <div class="card" v-for="(post, index) in posts"
             v-bind:index="index"
             v-bind:key="post.id"
        >
            <div class="card-content">
                <div class="media-content">
                    <p class="title is-4">{{ post.title }}</p>
                    <p class="subtitle is-6">{{ post.createdAt | formatDate }}</p>
                </div>
                <div class="content">
                    <p>{{ post.body }}</p>
                </div>
            </div>
            <footer class="card-footer">
                <a href="#" @click="editPost(post)" class="card-footer-item">Edit</a>
                <a href="#" @click="deletePost(post.id)" class="card-footer-item">Delete</a>
            </footer>
        </div>
    </div>
</template>

<script>
import PostService from '../PostService'
const postService = new PostService()

export default {
    name: 'Home',
    components: {
        PostForm: () => import('../components/PostForm')
    },
    data() {
        return {
            posts: [],
            editingPost: null,
        }

    },
    methods: {
        addPost(post) {
            const existingPostIdx = this.posts.findIndex(p => p.id === post.id)
            if (-1 !== existingPostIdx) {
                this.posts.splice(existingPostIdx, 1, post)
            } else {
                this.posts.unshift(post)
            }
        },
        editPost(post) {
            this.editingPost = post
        },
        deletePost(id) {
            postService.deletePost(id)
                .then(() => {
                    this.posts = this.posts.filter((post) => post.id !== id)
                })
                .catch(err => console.error(err))
        }
    },
    filters: {
        formatDate(dateStr) {
            const date = new Date(dateStr);

            let hours = date.getHours();
            let minutes = date.getMinutes();
            let ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            let strTime = hours + ':' + minutes + ' ' + ampm;
            return `${date.getMonth() + 1}-${date.getDate()}-${date.getFullYear()} ${strTime}`;
        }
    },
    created() {
        postService.getAllPosts()
            .then(res => {
                this.posts = res.data
            })
            .catch(err => console.error(err))
    }
}
</script>

<style scoped>
    .card {
        width: 40%;
        margin: 10px auto;
    }
</style>
