<template>
  <div class="main-app">
    <PhotoPost
        v-for="post in posts"
        :key="post.id"
        :username="post.username"
        :userAvatar="post.userAvatar"
        :postTime="post.postTime"
        :imageUrl="post.imageUrl"
        :caption="post.caption"
        :tags="post.tags"
        :comments="post.comments"
        @add-comment="addComment(post.id, $event)"
    />

  </div>
</template>

<script>
import PhotoPost from './PhotoPost.vue';

export default {
  data() {
    return {
      posts: [
        {
          id: 1,
          username: 'Christophe31',
          userAvatar: 'path/to/avatar.jpg',
          postTime: '2 hours ago',
          imageUrl: '../../public/images/avatar.jpg',
          caption: 'Enfin en haut !! JE SUIS LE GOAT !!',
          tags: ['MONTAGNE', 'MONT BLANC'],
          comments: [
            {id: 1, user: 'Francois', text: "J'adore la photo 😍", comDate: '1h'},
            {id: 2, user: 'Josianedu74', text: 'Whoua c\'est magnifique, mais ou est-ce ?', comDate: '1h'},
            {id: 3, user: 'Josianedu74', text: 'Whoua c\'est magnifique, mais ou est-ce ?', comDate: '1h'},
            {id: 4, user: 'Josianedu74', text: 'Whoua c\'est magnifique, mais ou est-ce ?', comDate: '1h'},
            {id: 5, user: 'Josianedu74', text: 'Whoua c\'est magnifique, mais ou est-ce ?', comDate: '1h'},
            {id: 6, user: 'Josianedu74', text: 'Whoua c\'est magnifique, mais ou est-ce ?', comDate: '1h'},
            {id: 6, user: 'Josianedu74', text: 'Whoua c\'est magnifique, mais ou est-ce ?', comDate: '1h'},
          ],
        },
        {
          id: 2,
          username: 'Josianedu74',
          userAvatar: '../../public/images/avatar.jpg',
          postTime: '3 hours ago',
          imageUrl: 'path/to/photo.jpg',
          caption: 'Petite balade en montagne',
          tags: ['MONTAGNE', 'RANDONNÉE'],
          comments: [
            {id: 1, user: 'Christophe31', text: 'Superbe photo !', comDate: '30min'},
          ],
        },
      ],
    };
  },
  methods: {
    addComment(postId, newComment) {
      const post = this.posts.find((p) => p.id === postId);
      if (post) {
        post.comments.push({id: Date.now(), user: 'currentUser', text: newComment});
      }
    },
  },
  components: {
    PhotoPost,
  },
};
</script>

<style>
* {
  font-family: 'Open Sans', sans-serif;
}

/* Styles globaux pour ton application */
.main-app {
  /* Ajoute ici les styles pour structurer ton composant */
  display: grid;
  flex-direction: column;
  justify-items: center;
}
</style>
