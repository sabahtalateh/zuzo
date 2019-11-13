<template>
    <div class="form">
        <form v-if="!loading"  @submit.prevent="onSubmit">
            <div class="field">
                <label class="label" for="title">Title</label>
                <div class="control">
                    <input id="title"
                           name="title"
                           class="input validate"
                           type="text"
                           placeholder="Text input"
                           v-model="title"
                    >
                </div>
            </div>
            <div class="field">
                <label class="label" for="body">Description</label>
                <div class="control">
                <textarea id="body"
                          name="body"
                          class="textarea"
                          placeholder="Body"
                          v-model="body"
                ></textarea>
                </div>
            </div>
            <div class="field is-grouped is-grouped-right">
                <p class="control">
                    <button type="submit" class="button is-primary">
                        {{ editingId ? 'Update' : 'Add' }}
                    </button>
                </p>
            </div>

        </form>
        <div class="container" v-if="loading">
            <button class="load button is-primary is-loading">Loading</button>
        </div>
    </div>
</template>

<script>
import PostService from '../PostService'
const postService = new PostService()

export default {
    name: 'PostForm',
    props: {
        editingPost: Object
    },
    data() {
        return {
            loading: false,
            title: '',
            body: '',
            editingId: null
        }
    },
    methods: {
        onSubmit() {
            if (this.title.trim() === '' || this.body.trim() === '') {
                return;
            }

            this.loading = true;
            const post = {
                id: this.editingId,
                title: this.title,
                body: this.body,
            }

            postService.writePost(post)
                .then(res => {
                    this.loading = false
                    this.title = ''
                    this.body = ''
                    this.$emit('postCreated', res.data)
                    console.log(res)
                })
                .catch(err => console.error(err))
        }
    },
    watch: {
        editingPost(post) {
            this.title = post.title
            this.body = post.body
            this.editingId = post.id
        }
    }
}
</script>

<style scoped>
    .form {
        width: 40%;
        margin: 10px auto;
    }

    .load{
        width: 100%;
    }
</style>
