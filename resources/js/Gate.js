export default class Gate{
	constructor(userType){
		this.type = userType;
	}

	isAdmin(){
		return this.type === 'admin';
	}

	isUser(){
		return this.type === 'user';
	}

	isAuthor(){
		return this.type === 'author';
	}

}