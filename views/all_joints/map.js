function (doc) {
	if (doc.class == 'BiscuitJoint\\JointDefinition') {
		emit([doc.state.partA, doc.state.type, doc.state.partB], {_id:doc._id});
		if(doc.state.symmetric){
			emit([doc.state.partB, doc.state.type, doc.state.partA], {_id:doc._id});
		}
	}
}
