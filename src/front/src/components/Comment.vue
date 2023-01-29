<template>
  <h1 class='Title'>Блок комментариев.</h1>
  <div class="Container">
    <div class="ImgNewComment">
      <img class="Img" src="../assets/Photo.jpg" alt="">
      <div class="Comments">
        <form class="NewComment">
          <div class="TitleName">Ваше имя</div>
          <input name="name" class="TitleNameValue" v-model="NameUser" placeholder="Имя" />
          <div class="TitleName">Ваш комментарий</div>
          <input name="comment" v-model="CommentUser" class="InputNewComment" placeholder="Комментарий" />
        </form>
        <VueRecaptcha :sitekey="sitekey" @verify="recVerify" @expired="onCaptchaExpired"></VueRecaptcha>
        <input type="submit" value="Добавить комментарий" class="ButtonNewComment" @click="PostComment()">
      </div>
    </div>
    <div>
      <div class="OldComments" v-for="Comment in OldComment">
        <div class="OldCommentName" >{{ Comment.Name }}
          <span class="OldCommentData">{{ Comment.Time }}</span>
        </div>
        <div class="OldCommentContent">{{ Comment.Comment }}</div>
        <img src="../assets/IconTrash.png" class="TrashIcon" @click="DeleteComment(Comment.Id)">
      </div>
    </div>
  </div>

</template>

<script>
import { VueRecaptcha } from 'vue-recaptcha';

export default {
  name: "Comment",
  components: { VueRecaptcha },
  data() {
    return {
      sitekey: '6LeRGzgkAAAAACiYinIraEuzW-3t_-116h3HhCLq',
      NameUser: '',
      CommentUser: '',
      OldComment: '',
      recaptcha: null
    }
  },
  methods: {
    DeleteComment: async function(Id){
      const res = await fetch(`http://back.api/${Id}`,{
        method: "DELETE"
      });
      const data= await res.json();
      if (data.status){
        this.GetData();
      }
    },
    recVerify(response) {
      this.recaptcha = response
    },
    onCaptchaExpired() {
      this.$refs.recaptcha.reset();
    },

    PostComment: async function () {
      if (this.NameUser != '' && this.CommentUser != '' && this.recaptcha) {
        let Data = new FormData();
        Data.append('name', this.NameUser);
        Data.append('comment', this.CommentUser);

        const res = await fetch('http://back.api', {
          method: 'Post',
          body: Data
        });
        //const resj= await res.json();
        //console.log(resj);
        this.GetData();
        this.NameUser='';
        this.CommentUser='';
      }

    },
    GetData: async function () {
      const res= await fetch('http://back.api');
      this.OldComment= await res.json();
      console.log(this.OldComment);
    },
  },
  mounted: function () {
    this.GetData();
  }
}
</script>

<style>
.Title {
  text-align: center;
  color: #fff;
}

.Container {
  display: grid;
  grid-template-columns: 70% 30%;
  height: 700px;
  width: 100%;
  color: #fff;
}

.ImgNewComment {
  height: auto;
}

.Img {
  width: 60%;
  height: 60%;
}

.Comments {
  width: 100%;
}

.TitleName {
  font-size: 16px;
}

.TitleNameValue {
  margin-bottom: 30px;
  height: 25px;
  width: 30%;
}

.InputNewComment {
  width: 30%;
  height: 70px;
}

.NewComment {
  margin-bottom: 30px;
}

.ButtonNewComment {
  appearance: none;
  border: 0;
  border-radius: 5px;
  background: #4676D7;
  color: #fff;
  padding: 8px 16px;
  font-size: 16px;
  margin-top: 30px;
  cursor: pointer;
}

.OldComments {
  background: #fff;
  height: 80px;
  width: 90%;
  color: black;
  font-size: 18px;
  border-radius: 10px;
  padding: 10px 10px;
  margin-left: -200px;
  margin-bottom: 20px;
}

.OldCommentName{
  display: flex;
  justify-content: space-between;
}

.OldCommentData {
  color: slategrey;
  font-size: 13px;
}

.OldCommentContent {
  margin-top: 20px;
}

.TrashIcon{
  display: none;
  margin-left: auto;
  width: 20px;
}

.OldComments:hover .TrashIcon{
  display: block;
}
</style>
