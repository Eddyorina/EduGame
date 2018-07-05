var promise = new Promise((resolve, reject) => {
    $.ajax({
        url: "server/CatalogUtility.php",
        method: "POST",
        data: {games: 1},
        success: (data, textStatus, jqXHR) => {
            if (!data["error"]){
                resolve(data["games"]);
            } else {
                reject(data["error_message"]);
            }
        },
        error: (jqXHR, textStatus, errorThrown) => {
            reject(errorThrown);
        },
        dataType: "json"
    })
});

promise.catch(errorThrown => console.log("The error: ", errorThrown)) 
.then((resolve) => {
    console.log("The games: ", resolve);
    ReactDOM.render(
        <Games games={resolve} />,
        document.getElementById("games")
    );
});


class GameCard1 extends React.Component {
    render() {
        return (
            <div className="card mx-2 my-4 border-primary" style={{width: "12rem"}}>
                <img className="card-img-top image-fluid d-block" src={this.props.thumbnail} alt={this.props.title}/>
                <div className="card-body">
                    <h5 className="card-title">{this.props.title}</h5>
                    {/* <p className="card-text">{this.props.subject}</p> */}
                </div>
                <div className="card-footer text-center">
                    <a className="btn btn-primary w-100" href={this.props.link}>Play</a>
                </div>
            </div>
        );
    }
}

class SubjectGames extends React.Component {

    render() {

        return (
            <div className="container my-5">
                <div className="subject-name font-weight-bold">{this.props.subject}</div>
                <div className="row">
                    {/* <div className="card-deck" > */}
                        {this.props.games.map((game, i) => {
                            if (i != 0 && i % 6 == 0) {
                                return (
                                    <div>
                                    <div className="w-100"></div>
                                    <GameCard1 
                                        thumbnail={game.thumbnail}
                                        title={game.name}
                                        link={game.link}
                                    />
                                    </div>
                                );
                            }
                            return (
                                <GameCard1 
                                    thumbnail={game.thumbnail}
                                    title={game.name}
                                    link={game.link}
                                />
                            );
                        })}
                    {/* </div> */}
                </div>
            </div>
        );
    }
}

class Games extends React.Component {
    render() {
        let subjects = [];
        for (let subject in this.props.games)
            subjects.push(subject);

        return (
            <div className="container">
                {subjects.map(subject => {
                    return (
                        <SubjectGames subject={subject} games={this.props.games[subject]} />
                    );
                })}
            </div>
        );
    }
}

