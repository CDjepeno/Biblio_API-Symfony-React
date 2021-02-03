import React, { useEffect, useState } from "react";
import Button from "@material-ui/core/Button";
import CssBaseline from "@material-ui/core/CssBaseline";
import Grid from "@material-ui/core/Grid";
import Typography from "@material-ui/core/Typography";
import { makeStyles } from "@material-ui/core/styles";
import Container from "@material-ui/core/Container";
import Link from "@material-ui/core/Link";
import bookAPI from "../services/bookAPI";
import Pagination from "../componant/Pagination";
import { InputBase } from "@material-ui/core";
import SearchIcon from '@material-ui/icons/Search';


function Copyright() {
  return (
    <Typography variant="body2" color="textSecondary" align="center">
      {"Copyright © "}
      <Link color="inherit" href="https://material-ui.com/">
        Biblio
      </Link>{" "}
      {new Date().getFullYear()}
      {"."}
    </Typography>
  );
}

const useStyles = makeStyles((theme) => ({
  icon: {
    marginRight: theme.spacing(2),
  },
  heroContent: {
    backgroundColor: theme.palette.background.paper,
    padding: theme.spacing(8, 0, 6),
  },
  root: {
    '& > *': {
      marginTop: theme.spacing(2),
    },
  },
  heroButtons: {
    marginTop: theme.spacing(4),
  },
  cardGrid: {
    paddingTop: theme.spacing(8),
    paddingBottom: theme.spacing(8),
  },
  card: {
    height: "100%",
    display: "flex",
    flexDirection: "column",
  },
  cardMedia: {
    paddingTop: "56.25%", // 16:9
  },
  cardContent: {
    flexGrow: 1,
  },
  footer: {
    backgroundColor: theme.palette.background.paper,
    padding: theme.spacing(6),
  },
}));

const Main = ({ history }) => {
	const [currentPage, setCurrentPage] = useState(1);
	const [books, setBooks] 		    = useState([]);
	const [search, setSearch]           = useState("")
	const itemsPerPage 	= 8;
	const classes       = useStyles();

	const fetchBooks = async() => {
		try {
			const data = await bookAPI.findAll();
			setBooks(data)
		} catch (error) {
			console.log(error.message);
		}
	}

	const handleSearch = ({ currentTarget }) => {
		setSearch(currentTarget.value);
		setCurrentPage(1);
	}

	const goToBook = (id) => {
		history.push(`/book/${id}`)
	}

	useEffect(() => {
		fetchBooks();
	}, []);

	// Gestion du changement de page
	const handlePageChange = page => setCurrentPage(page);
	
	
	// filtrage en fonction de la recherche
	const filteredBooks = books.filter(b => b.title.toLowerCase().includes(search.toLocaleLowerCase()));
	
	// pagination des données
	const paginatedBooks = Pagination.getData(filteredBooks, currentPage, itemsPerPage);
	// paginatedBooks.map(book => {
	// 	console.log(book.isbn)
	// });
	return (
		<>
		<React.Fragment>
			<CssBaseline />
			<main>
				<div className={classes.search}>
					<SearchIcon />
					<InputBase
					placeholder="Search…"
					classes={{
						root: classes.inputRoot,
						input: classes.inputInput,
						}}
					inputProps={{ 'aria-label': 'search' }}
					value={search}
					onChange={handleSearch}
					/>
				</div>
				{/* Hero unit */}
				<div className={classes.heroContent}>
					<Container maxWidth="sm">
					<Typography
						component="h1"
						variant="h2"
						align="center"
						color="textPrimary"
						gutterBottom
					>
						Biblio
					</Typography>
					<Typography
						variant="h5"
						align="center"
						color="textSecondary"
						paragraph
					>
						Choisissez vos livres parmi des auteurs très talentueux !
					</Typography>
					<div className={classes.heroButtons}>
						<Grid container spacing={2} justify="center">
						<Grid item>
							<Button variant="contained" color="primary">
							Auteurs
							</Button>
						</Grid>
						<Grid item>
							<Button variant="outlined" color="primary">
							Editeurs
							</Button>
						</Grid>
						</Grid>
					</div>
					</Container>
				</div>
				<Container className={classes.cardGrid} maxWidth="md">
					<Grid container spacing={1}>
						{paginatedBooks.map(book => (
							<Grid item  xs={12} sm={8} md={3} key={book.isbn} >
									<a className="title-book">{book.title}</a>
								<Link to="#">
									<img src={book.picture} alt={book.title} className="img-bookcover" onClick={() => goToBook(book.id)}/>
								</Link>
							</Grid>
						))}
					</Grid>
					<div className={classes.root}>
						<Pagination
							currentPage={currentPage} 
							itemsPerPage={itemsPerPage} 
							length={books.length} 
							onPageChanged={handlePageChange}  
						/>
					</div>	
				</Container>
			</main>
			{/* Footer */}
			<footer className={classes.footer}>
			<Typography variant="h6" align="center" gutterBottom>
				Biblio
			</Typography>
			<Typography
				variant="subtitle1"
				align="center"
				color="textSecondary"
				component="p"
			>
				Lire c'est la vie !!!
			</Typography>
			<Copyright />
			</footer>
			{/* End footer */}
		</React.Fragment>
		</>
	);
};

export default Main;
